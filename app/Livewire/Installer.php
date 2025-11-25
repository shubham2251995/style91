<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Installer extends Component
{
    public $step = 1;

    // Step 2: App Config
    public $app_name = 'Style91';
    public $app_url = '';
    public $app_theme = 'bewakoof';
    
    // Step 3: DB Config
    public $db_host = '127.0.0.1';
    public $db_port = '3306';
    public $db_database = 'style91';
    public $db_username = 'root';
    public $db_password = '';

    // Step 5: Admin
    public $admin_name = 'Admin';
    public $admin_email = 'admin@style91.com';
    public $admin_mobile = '';
    public $admin_password = '';

    public $requirements = [
        'php' => '8.1.0',
        'extensions' => ['bcmath', 'ctype', 'json', 'mbstring', 'openssl', 'pdo', 'tokenizer', 'xml']
    ];

    public $status = [];

    public function mount()
    {
        $this->app_url = url('/');
        $this->checkRequirements();
        $this->ensureAppKey();
    }

    public function ensureAppKey()
    {
        // Auto-generate APP_KEY if missing
        if (empty(config('app.key'))) {
            $key = 'base64:' . base64_encode(random_bytes(32));
            $this->updateEnv(['APP_KEY' => $key]);
        }
    }

    public function checkRequirements()
    {
        $this->status['php'] = version_compare(phpversion(), $this->requirements['php'], '>=');
        foreach ($this->requirements['extensions'] as $ext) {
            $this->status[$ext] = extension_loaded($ext);
        }
    }

    public function nextStep()
    {
        $this->step++;
    }

    public function saveAppConfig()
    {
        $this->validate([
            'app_name' => 'required',
            'app_url' => 'required|url',
            'app_theme' => 'required',
        ]);

        $this->updateEnv([
            'APP_NAME' => '"' . $this->app_name . '"',
            'APP_URL' => $this->app_url,
            'APP_THEME' => $this->app_theme,
            'DB_CONNECTION' => 'mysql',
        ]);

        $this->ensureAppKey();
        $this->step++;
    }

    public function saveDatabase()
    {
        $this->validate([
            'db_host' => 'required',
            'db_database' => 'required',
            'db_username' => 'required',
        ]);

        $this->updateEnv([
            'DB_CONNECTION' => 'mysql',
            'DB_HOST' => $this->db_host,
            'DB_PORT' => $this->db_port,
            'DB_DATABASE' => $this->db_database,
            'DB_USERNAME' => $this->db_username,
            'DB_PASSWORD' => $this->db_password,
        ]);

        // Clear config cache - MOVED to runMigrations to prevent session issues
        // $this->manualConfigClear();

        // Test Connection
        try {
            DB::purge('mysql');
            config(['database.connections.mysql.host' => $this->db_host]);
            config(['database.connections.mysql.port' => $this->db_port]);
            config(['database.connections.mysql.database' => $this->db_database]);
            config(['database.connections.mysql.username' => $this->db_username]);
            config(['database.connections.mysql.password' => $this->db_password]);
            
            DB::connection('mysql')->getPdo();
            
            $this->step++;
        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
            
            if (str_contains($errorMsg, 'Access denied')) {
                $this->addError('db_connection', '❌ Access Denied: Check your database username and password.');
            } elseif (str_contains($errorMsg, 'Unknown database')) {
                $this->addError('db_connection', '❌ Database not found: Please create the database "' . $this->db_database . '" in cPanel/phpMyAdmin first.');
            } elseif (str_contains($errorMsg, "Can't connect") || str_contains($errorMsg, 'Connection refused')) {
                $this->addError('db_connection', '❌ Cannot connect to host. For Hostinger, use "localhost".');
            } else {
                $this->addError('db_connection', '❌ Connection failed: ' . $errorMsg);
            }
        }
    }

    public function runMigrations()
    {
        set_time_limit(600); // Increase timeout to 10 minutes
        ini_set('memory_limit', '512M'); // Increase memory limit
        
        try {
            $this->manualConfigClear();
            
            // Check if migrations already run
            $tablesExist = false;
            try {
                // Check if users table exists (indicates migrations already ran)
                DB::connection('mysql')->table('users')->limit(1)->count();
                $tablesExist = true;
            } catch (\Exception $e) {
                // Table doesn't exist, we need to migrate
                $tablesExist = false;
            }
            
            if ($tablesExist) {
                // Migrations already completed, just move to next step
                session()->flash('migration_success', 'Database already migrated! Moving to next step...');
                $this->step = 5;
                return;
            }
            
            // Run migrations
            \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true]);
            
            // Run seeders (optional - comment out if causing issues)
            try {
                \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            } catch (\Exception $seedError) {
                // Seeding is optional, log error but continue
                \Illuminate\Support\Facades\Log::warning('Seeding failed: ' . $seedError->getMessage());
            }
            
            // Force step increment
            $this->step = 5;
            
            // Flash success message
            session()->flash('migration_success', 'Database migrated successfully!');
            
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            
            // Check if error is about duplicate/already exists
            if (str_contains($errorMessage, 'Duplicate') || 
                str_contains($errorMessage, 'already exists') ||
                str_contains($errorMessage, 'Base table or view already exists')) {
                // Tables already exist, just proceed
                session()->flash('migration_success', 'Database tables already exist. Proceeding...');
                $this->step = 5;
            } else {
                $this->addError('migration', 'Migration failed: ' . $errorMessage);
                \Illuminate\Support\Facades\Log::error('Migration Error: ' . $errorMessage);
            }
        }
    }

    public function createAdmin()
    {
        $this->validate([
            'admin_name' => 'required',
            'admin_email' => 'required|email',
            'admin_mobile' => 'required',
            'admin_password' => 'required|min:8',
        ]);

        try {
            $admin = User::create([
                'name' => $this->admin_name,
                'email' => $this->admin_email,
                'password' => Hash::make($this->admin_password),
                'role' => 'admin',
                'mobile' => $this->admin_mobile
            ]);

            // Auto-login the admin
            auth()->login($admin);
            session()->regenerate();

            // Finalize - Exec-Free Methods
            $this->createStorageLink();
            $this->manualCacheClear();
            
            $this->updateEnv([
                'APP_ENV' => 'production',
                'APP_DEBUG' => 'false',
                'SESSION_DRIVER' => 'database',
            ]);

            file_put_contents(storage_path('installed'), 'INSTALLED ON ' . now());
            
            $this->step++;
        } catch (\Exception $e) {
            $this->addError('admin', 'Failed to create admin: ' . $e->getMessage());
        }
    }

    /**
     * Create storage symlink without using exec/shell commands
     * If symlink() is disabled, we silently skip (not critical for installation)
     */
    protected function createStorageLink()
    {
        // Storage linking is optional - if it fails, the app still works
        try {
            $target = storage_path('app/public');
            $link = public_path('storage');

            // Remove existing link if it exists
            if (file_exists($link) && is_link($link)) {
                @unlink($link);
            }

            // Try to create symlink - will fail silently if function is disabled
            if (function_exists('symlink')) {
                @symlink($target, $link);
            }
        } catch (\Exception $e) {
            // Silently fail - storage linking is not critical
        }
    }

    protected function manualConfigClear()
    {
        $configCache = base_path('bootstrap/cache/config.php');
        if (file_exists($configCache)) {
            @unlink($configCache);
        }
    }

    protected function manualCacheClear()
    {
        // Clear config
        $this->manualConfigClear();

        // Clear routes
        $routeCache = base_path('bootstrap/cache/routes-v7.php');
        if (file_exists($routeCache)) {
            @unlink($routeCache);
        }

        // Clear views
        $viewPath = storage_path('framework/views');
        if (is_dir($viewPath)) {
            $files = glob($viewPath . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
    }

    protected function updateEnv($data = [])
    {
        $path = base_path('.env');
        
        if (!file_exists($path)) {
            // If .env doesn't exist, create from .env.example
            $examplePath = base_path('.env.example');
            if (file_exists($examplePath)) {
                copy($examplePath, $path);
            } else {
                // Create minimal .env
                file_put_contents($path, '');
            }
        }
        
        $content = file_get_contents($path);
        
        foreach ($data as $key => $value) {
            // Escape special characters in value for regex
            $escapedValue = str_replace(['$', '\\'], ['\\$', '\\\\'], $value);
            
            // Check if key exists in .env
            if (preg_match("/^{$key}=/m", $content)) {
                // Update existing key
                $content = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}={$escapedValue}",
                    $content
                );
            } else {
                // Add new key at the end
                $content .= "\n{$key}={$escapedValue}";
            }
        }
        
        file_put_contents($path, $content);
        
        // Force config reload
        if (function_exists('opcache_reset')) {
            @opcache_reset();
        }
    }

    public function render()
    {
        return view('livewire.installer')->layout('components.layouts.app');
    }
}
