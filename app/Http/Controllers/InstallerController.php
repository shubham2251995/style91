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
        // Check if already installed
        if (file_exists(storage_path('installed'))) {
            return redirect('/');
        }

        return view('installer-standalone');
    }

    public function install(Request $request)
    {
        try {
            // Update .env
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

            // Clear config
            $this->clearConfig();

            // Test DB connection
            config(['database.connections.mysql.host' => $request->db_host]);
            config(['database.connections.mysql.port' => $request->db_port ?? '3306']);
            config(['database.connections.mysql.database' => $request->db_database]);
            config(['database.connections.mysql.username' => $request->db_username]);
            config(['database.connections.mysql.password' => $request->db_password]);
            
            DB::purge('mysql');
            DB::connection('mysql')->getPdo();

            // Run migrations
            Artisan::call('migrate:fresh', ['--force' => true]);

            // Create admin
            User::create([
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'role' => 'admin',
                'mobile' => $request->admin_mobile ?? '',
            ]);

            // Mark as installed
            file_put_contents(storage_path('installed'), 'INSTALLED ON ' . now());

            return response()->json(['success' => true, 'message' => 'Installation complete!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
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
