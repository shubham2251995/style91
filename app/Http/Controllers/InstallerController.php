<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Controllers\Controller;

class InstallerController extends Controller
{
    public function index()
    {
        if (file_exists(storage_path('installed'))) {
            return redirect('/');
        }
        return view('installer');
    }

    public function checkRequirements(Request $request)
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
        return response()->json(['success' => true, 'requirements' => $requirements]);
    }

    public function testDatabase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'db_host' => 'required',
            'db_database' => 'required',
            'db_username' => 'required',
            'app_name' => 'required',
            'app_url' => 'required|url',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }
        try {
            $pdo = new \PDO(
                "mysql:host={$request->db_host};port=" . ($request->db_port ?? '3306') . ";dbname={$request->db_database}",
                $request->db_username,
                $request->db_password,
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
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
            $stmt = $pdo->query('SHOW TABLES');
            $tableCount = $stmt->rowCount();
            return response()->json([
                'success' => true,
                'tables_exist' => $tableCount > 0,
                'table_count' => $tableCount,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $this->getFriendlyDbError($e->getMessage())], 400);
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
            $this->updateEnv([
                'APP_NAME' => "\"{$appConfig['name']}\"",
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
            $this->clearAllCaches();
            config([
                'database.connections.mysql.host' => $dbConfig['host'],
                'database.connections.mysql.port' => $dbConfig['port'],
                'database.connections.mysql.database' => $dbConfig['database'],
                'database.connections.mysql.username' => $dbConfig['username'],
                'database.connections.mysql.password' => $dbConfig['password'],
            ]);
            DB::purge('mysql');
            DB::reconnect('mysql');
            Artisan::call('migrate:fresh', ['--force' => true]);
            try {
                Artisan::call('db:seed', ['--force' => true]);
            } catch (\Exception $e) {
                // ignore seed errors
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function createAdmin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
            }
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin',
                'mobile' => $request->mobile ?? '',
            ]);
            file_put_contents(storage_path('installed'), 'INSTALLED ON ' . now());
            session()->forget(['installer_db', 'installer_app']);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function updateEnv(array $data)
    {
        $path = base_path('.env');
        if (!file_exists($path)) {
            copy(base_path('.env.example'), $path);
        }
        $content = file_get_contents($path);
        if (!preg_match('/^APP_KEY=/m', $content)) {
            $appKey = 'base64:' . base64_encode(random_bytes(32));
            $content .= "\nAPP_KEY={$appKey}";
        }
        foreach ($data as $key => $value) {
            $escaped = addslashes($value);
            if (preg_match("/^{$key}=.*/m", $content)) {
                $content = preg_replace("/^{$key}=.*/m", "{$key}={$escaped}", $content);
            } else {
                $content .= "\n{$key}={$escaped}";
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
            array_map('unlink', glob($viewsPath . '/*'));
        }
    }

    private function getFriendlyDbError(string $message): string
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
