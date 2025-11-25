<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class InstallerController extends Controller
{
    public function index()
    {
        if (file_exists(storage_path('installed'))) {
            return redirect('/');
        }

        return view('installer');
    }

    public function checkRequirements()
    {
        $requirements = [
            'php_version' => version_compare(PHP_VERSION, '8.1.0', '>='),
            'bcmath' => extension_loaded('bcmath'),
            'ctype' => extension_loaded('ctype'),
            'json' => extension_loaded('json'),
            'mbstring' => extension_loaded('mbstring'),
            'openssl' => extension_loaded('openssl'),
            'pdo' => extension_loaded('pdo'),
            'pdo_mysql' => extension_loaded('pdo_mysql'),
            'tokenizer' => extension_loaded('tokenizer'),
            'xml' => extension_loaded('xml'),
            'storage_writable' => is_writable(storage_path()),
            'cache_writable' => is_writable(base_path('bootstrap/cache')),
        ];

        $allPassed = !in_array(false, $requirements);

        return response()->json([
            'success' => $allPassed,
            'requirements' => $requirements,
        ]);
    }

    public function testDatabase(Request $request)
    {
        try {
            $validated = $request->validate([
                'db_host' => 'required',
                'db_database' => 'required',
                'db_username' => 'required',
                'app_name' => 'required',
                'app_url' => 'required|url',
            ]);

            // Test connection
            $pdo = new \PDO(
                "mysql:host={$request->db_host};port={$request->db_port};dbname={$request->db_database}",
                $request->db_username,
                $request->db_password,
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );

            // Store in session
            session([
                'installer_db' => [
                    'host' => $request->db_host,
                    'port' => $request->db_port ?? '3306',
                    'database' => $request->db_database,
                    'username' => $request->db_username,
                    'password' => $request->db_password,
                ],
                'installer_app' => [
                    'name' => $request->app_name,
                    'url' => $request->app_url,
                ]
            ]);

            // Check for existing tables
            $stmt = $pdo->query('SHOW TABLES');
            $tableCount = $stmt->rowCount();

            return response()->json([
                'success' => true,
                'tables_exist' => $tableCount > 0,
                'table_count' => $tableCount,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $this->getFriendlyDbError($e->getMessage())
            ], 400);
        }
    }

    public function install(Request $request)
    {
        try {
            $dbConfig = session('installer_db');
            $appConfig = session('installer_app');

            if (!$dbConfig || !$appConfig) {
                throw new \Exception('Session expired. Please start over.');
            }

            // 1. Update .env
            $this->updateEnv([
                'APP_NAME' => '"' . $appConfig['name'] . '"',
                'APP_URL' => $appConfig['url'],
                'APP_ENV' => 'production',
                'APP_DEBUG' => 'false',
                'DB_CONNECTION' => 'mysql',
                'DB_HOST' => $dbConfig['host'],
                'DB_PORT' => $dbConfig['port'],
                'DB_DATABASE' => $dbConfig['database'],
                'DB_USERNAME' => $dbConfig['username'],
                'DB_PASSWORD' => $dbConfig['password'],
                'SESSION_DRIVER' => 'database',
            ]);

            // 2. Clear caches
            $this->clearAllCaches();

            // 3. Reconnect to database with new credentials
            config(['database.connections.mysql.host' => $dbConfig['host']]);
            config(['database.connections.mysql.port' => $dbConfig['port']]);
            config(['database.connections.mysql.database' => $dbConfig['database']]);
            config(['database.connections.mysql.username' => $dbConfig['username']]);
            config(['database.connections.mysql.password' => $dbConfig['password']]);
            
            DB::purge('mysql');
            DB::reconnect('mysql');

            // 4. Drop all existing tables
            $droppedCount = $this->dropAllTables();

            // 5. Run migrations
            $migrator = app('migrator');
            $repository = $migrator->getRepository();
            
            // Create migrations table if it doesn't exist
            if (!$repository->repositoryExists()) {
                $repository->createRepository();
            }
            
            // Get pending migrations only
            $files = $migrator->getMigrationFiles([database_path('migrations')]);
            $ran = $repository->getRan();
            $pending = array_diff(array_keys($files), $ran);
            
            // Only run if there are pending migrations
            if (!empty($pending)) {
                $migrator->run([database_path('migrations')]);
            }

            // 6. Run seeders (optional)
            try {
                Artisan::call('db:seed', ['--force' => true]);
            } catch (\Exception $e) {
                // Seeding is optional
            }

            return response()->json([
                'success' => true,
                'tables_dropped' => $droppedCount,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function createAdmin(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin',
                'mobile' => $request->mobile ?? '',
            ]);

            // Mark as installed
            file_put_contents(storage_path('installed'), 'INSTALLED ON ' . now());

            // Clear session
            session()->forget(['installer_db', 'installer_app']);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function dropAllTables()
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            $tables = DB::select('SHOW TABLES');
            $droppedCount = 0;
            
            if (!empty($tables)) {
                $firstTable = (array) $tables[0];
                $columnName = array_keys($firstTable)[0];
                
                foreach ($tables as $table) {
                    $tableArray = (array) $table;
                    $tableName = $tableArray[$columnName];
                    
                    DB::statement("DROP TABLE IF EXISTS `{$tableName}`");
                    $droppedCount++;
                }
            }
            
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            return $droppedCount;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function updateEnv($data)
    {
        $path = base_path('.env');
        
        if (!file_exists($path)) {
            copy(base_path('.env.example'), $path);
        }
        
        $content = file_get_contents($path);
        
        // Ensure APP_KEY exists
        if (!preg_match('/^APP_KEY=/m', $content)) {
            $appKey = 'base64:' . base64_encode(random_bytes(32));
            $content .= "\nAPP_KEY={$appKey}";
        }
        
        foreach ($data as $key => $value) {
            $escapedValue = addslashes($value);
            
            if (preg_match("/^{$key}=/m", $content)) {
                $content = preg_replace("/^{$key}=.*/m", "{$key}={$escapedValue}", $content);
            } else {
                $content .= "\n{$key}={$escapedValue}";
            }
        }
        
        file_put_contents($path, $content);
    }

    private function clearAllCaches()
    {
        @unlink(base_path('bootstrap/cache/config.php'));
        @unlink(base_path('bootstrap/cache/routes-v7.php'));
        
        $viewsPath = storage_path('framework/views');
        if (is_dir($viewsPath)) {
            array_map('unlink', glob($viewsPath.'/*'));
        }
    }

    private function getFriendlyDbError($message)
    {
        if (str_contains($message, 'Access denied')) {
            return 'Access Denied: Check your database username and password.';
        } elseif (str_contains($message, 'Unknown database')) {
            return 'Database not found. Please create the database first.';
        } elseif (str_contains($message, "Can't connect") || str_contains($message, 'Connection refused')) {
            return 'Cannot connect to database server. Try using "localhost" instead of "127.0.0.1" (or vice versa).';
        }
        return $message;
    }
}
