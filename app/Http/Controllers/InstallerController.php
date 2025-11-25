<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InstallerController extends Controller
{
    public function index()
    {
        if (file_exists(storage_path('installed'))) {
            return redirect('/');
        }

        return view('installer-multi-step');
    }

    // Step 1: Check requirements
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
            'tokenizer' => extension_loaded('tokenizer'),
            'xml' => extension_loaded('xml'),
            'storage_writable' => is_writable(storage_path()),
            'cache_writable' => is_writable(base_path('bootstrap/cache')),
        ];

        $allPassed = !in_array(false, $requirements);

        return response()->json([
            'success' => $allPassed,
            'requirements' => $requirements,
            'message' => $allPassed ? 'All requirements met!' : 'Some requirements not met'
        ]);
    }

    // Step 2: Test database connection
    public function testDatabase(Request $request)
    {
        try {
            $request->validate([
                'db_host' => 'required',
                'db_database' => 'required',
                'db_username' => 'required',
            ]);

            config(['database.connections.mysql.host' => $request->db_host]);
            config(['database.connections.mysql.port' => $request->db_port ?? '3306']);
            config(['database.connections.mysql.database' => $request->db_database]);
            config(['database.connections.mysql.username' => $request->db_username]);
            config(['database.connections.mysql.password' => $request->db_password]);
            
            DB::purge('mysql');
            DB::connection('mysql')->getPdo();

            // Check if tables exist
            $tables = DB::select('SHOW TABLES');
            $tableCount = count($tables);

            return response()->json([
                'success' => true,
                'message' => 'Database connection successful!',
                'tables_exist' => $tableCount > 0,
                'table_count' => $tableCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $this->getFriendlyDbError($e->getMessage())
            ], 400);
        }
    }

    // Step 3: Clean database
    public function cleanDatabase(Request $request)
    {
        try {
            // Reconnect with provided credentials
            config(['database.connections.mysql.host' => $request->db_host]);
            config(['database.connections.mysql.port' => $request->db_port ?? '3306']);
            config(['database.connections.mysql.database' => $request->db_database]);
            config(['database.connections.mysql.username' => $request->db_username]);
            config(['database.connections.mysql.password' => $request->db_password]);
            
            DB::purge('mysql');

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            $tables = DB::select('SHOW TABLES');
            $droppedTables = [];
            
            if (!empty($tables)) {
                $firstTable = (array) $tables[0];
                $columnName = array_keys($firstTable)[0];
                
                foreach ($tables as $table) {
                    $tableArray = (array) $table;
                    $tableName = $tableArray[$columnName];
                    
                    DB::statement("DROP TABLE IF EXISTS `{$tableName}`");
                    $droppedTables[] = $tableName;
                }
            }
            
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            return response()->json([
                'success' => true,
                'message' => 'Database cleaned successfully!',
                'dropped_tables' => $droppedTables,
                'count' => count($droppedTables)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clean database: ' . $e->getMessage()
            ], 500);
        }
    }

    // Step 4: Run migrations
    public function runMigrations(Request $request)
    {
        try {
            // Update .env first
            $this->updateEnv([
                'APP_NAME' => '"' . $request->app_name . '"',
                'APP_URL' => $request->app_url,
                'DB_HOST' => $request->db_host,
                'DB_PORT' => $request->db_port ?? '3306',
                'DB_DATABASE' => $request->db_database,
                'DB_USERNAME' => $request->db_username,
                'DB_PASSWORD' => $request->db_password,
                'SESSION_DRIVER' => 'database',
            ]);

            $this->clearConfig();

            // Reconnect
            config(['database.connections.mysql.host' => $request->db_host]);
            config(['database.connections.mysql.port' => $request->db_port ?? '3306']);
            config(['database.connections.mysql.database' => $request->db_database]);
            config(['database.connections.mysql.username' => $request->db_username]);
            config(['database.connections.mysql.password' => $request->db_password]);
            
            DB::purge('mysql');

            // ALWAYS clean database before migration to prevent conflicts
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

            // Now run migrations on clean database
            Artisan::call('migrate', ['--force' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Migrations completed successfully!',
                'tables_dropped' => $droppedCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Migration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    // Step 5: Seed database
    public function seedDatabase()
    {
        try {
            Artisan::call('db:seed', ['--force' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Database seeded successfully!'
            ]);
        } catch (\Exception $e) {
            // Seeding is optional
            return response()->json([
                'success' => true,
                'message' => 'Seeding skipped (optional)',
                'warning' => $e->getMessage()
            ]);
        }
    }

    // Step 6: Create admin
    public function createAdmin(Request $request)
    {
        try {
            $request->validate([
                'admin_name' => 'required',
                'admin_email' => 'required|email',
                'admin_password' => 'required|min:8',
            ]);

            User::create([
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'role' => 'admin',
                'mobile' => $request->admin_mobile ?? '',
            ]);

            // Mark as installed
            file_put_contents(storage_path('installed'), 'INSTALLED ON ' . now());

            return response()->json([
                'success' => true,
                'message' => 'Admin account created! Installation complete!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create admin: ' . $e->getMessage()
            ], 500);
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
        return 'Database error: ' . $message;
    }

    private function updateEnv($data)
    {
        $path = base_path('.env');
        
        if (!file_exists($path)) {
            copy(base_path('.env.example'), $path);
        }
        
        $content = file_get_contents($path);
        
        foreach ($data as $key => $value) {
            $escapedValue = str_replace(['$', '\\'], ['\\$', '\\\\'], $value);
            
            if (preg_match("/^{$key}=/m", $content)) {
                $content = preg_replace("/^{$key}=.*/m", "{$key}={$escapedValue}", $content);
            } else {
                $content .= "\n{$key}={$escapedValue}";
            }
        }
        
        file_put_contents($path, $content);
    }

    private function clearConfig()
    {
        $configCache = base_path('bootstrap/cache/config.php');
        if (file_exists($configCache)) {
            @unlink($configCache);
        }
    }
}
