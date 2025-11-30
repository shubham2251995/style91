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
    public $migration_progress = 0;
    public $migration_message = 'Preparing database...';

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
            $this->migration_progress = 10;
            $this->migration_message = 'Clearing caches...';
            $this->manualConfigClear();
            
            $this->migration_progress = 20;
            $this->migration_message = 'Checking existing database...';
            
            // Check if migrations already run
            $tablesExist = false;
            try {
                DB::connection('mysql')->table('users')->limit(1)->count();
                $tablesExist = true;
            } catch (\Exception $e) {
                $tablesExist = false;
            }
            
            if ($tablesExist) {
                // Migrations already completed
                session()->flash('migration_success', 'Database already migrated! Moving to next step...');
                $this->step = 5;
                $this->initializePlugins(); // Ensure plugins are initialized
                return;
            }
            
            $this->migration_progress = 30;
            $this->migration_message = 'Running database migrations...';
            
            // Run migrations with progress tracking
            \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true]);
            
            $this->migration_progress = 70;
            $this->migration_message = 'Seeding initial data...';
            
            // Run seeders (optional)
            try {
                \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            } catch (\Exception $seedError) {
                \Illuminate\Support\Facades\Log::warning('Seeding failed: ' . $seedError->getMessage());
            }
            
            $this->migration_progress = 90;
            $this->migration_message = 'Initializing plugin system...';
            
            // Initialize plugins
            $this->initializePlugins();
            
            $this->migration_progress = 100;
            $this->migration_message = 'Database setup complete!';
            
            // Force step increment
            $this->step = 5;
            session()->flash('migration_success', 'Database migrated successfully!');
            
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            
            // Check if error is about duplicate/already exists
            if (str_contains($errorMessage, 'Duplicate') || 
                str_contains($errorMessage, 'already exists') ||
                str_contains($errorMessage, 'Base table or view already exists')) {
                session()->flash('migration_success', 'Database tables already exist. Proceeding...');
                $this->step = 5;
                $this->initializePlugins();
            } else {
                $this->migration_progress = 0;
                $this->migration_message = 'Migration failed';
                $this->addError('migration', 'Migration failed: ' . $this->getFriendlyMigrationError($errorMessage));
                \Illuminate\Support\Facades\Log::error('Migration Error: ' . $errorMessage);
            }
        }
    }

    /**
     * Make migration errors more user-friendly
     */
    protected function getFriendlyMigrationError($message)
    {
        if (str_contains($message, 'max_allowed_packet')) {
            return 'Database packet size too small. Contact your host to increase max_allowed_packet.';
        } elseif (str_contains($message, 'Syntax error')) {
            return 'SQL syntax error. Your MySQL version might be outdated (requires 5.7+).';
        } elseif (str_contains($message, 'timeout') || str_contains($message, 'timed out')) {
            return 'Database operation timed out. Try again or contact your hosting provider.';
        } elseif (str_contains($message, 'Deadlock')) {
            return 'Database deadlock detected. Please try again.';
        } elseif (str_contains($message, 'Access denied')) {
            return 'Database user lacks required permissions. Grant ALL PRIVILEGES on database.';
        }
        
        // Truncate long error messages
        return strlen($message) > 200 ? substr($message, 0, 200) . '...' : $message;
    }

    /**
     * Initialize plugin system after migrations
     */
    protected function initializePlugins()
    {
        try {
            // This will create plugin records in database if they don't exist
            $pluginManager = app(\App\Services\PluginManager::class);
            $pluginManager->loadPlugins();
        } catch (\Exception $e) {
            // Not critical, log and continue
            \Log::warning('Plugin initialization warning: ' . $e->getMessage());
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

            // Post-Installation Tasks for Shared Hosting
            $this->runPostInstallationTasks();
            
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
     * Shared hosting compatible - tries symlink, falls back to manual copy
     */
    protected function createStorageLink()
    {
        try {
            $target = storage_path('app/public');
            $link = public_path('storage');

            // Remove existing link if it exists
            if (file_exists($link)) {
                if (is_link($link)) {
                    @unlink($link);
                } elseif (is_dir($link)) {
                    // Already exists as directory, skip
                    return;
                }
            }

            // Try symlink first (works on most shared hosting)
            if (function_exists('symlink') && !function_exists('is_disabled') && !in_array('symlink', explode(',', ini_get('disable_functions')))) {
                @symlink($target, $link);
            } else {
                // Fallback: Create info file for manual setup
                $infoFile = public_path('STORAGE_LINK_NEEDED.txt');
                file_put_contents($infoFile, 
                    "Symlink function is disabled on your server.\n\n" .
                    "Please create a symbolic link manually:\n" .
                    "Source: " . $target . "\n" .
                    "Destination: " . $link . "\n\n" .
                    "Contact your hosting support or use File Manager to create symlink."
                );
            }
        } catch (\Exception $e) {
            // Silently fail - not critical for initial installation
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

    /**
     * Post-installation tasks for shared hosting
     * Optimizes the application for production use
     */
    protected function runPostInstallationTasks()
    {
        $tasks = [
            'storage_link' => ['name' => 'Creating storage symlink', 'method' => 'createStorageLink'],
            'caches' => ['name' => 'Clearing caches', 'method' => 'manualCacheClear'],
            'production_caches' => ['name' => 'Generating production caches', 'method' => 'generateProductionCaches'],
            'directories' => ['name' => 'Creating required directories', 'method' => 'ensureDirectoriesExist'],
            'permissions' => ['name' => 'Checking file permissions', 'method' => 'checkFilePermissions'],
            'htaccess' => ['name' => 'Verifying .htaccess', 'method' => 'verifyHtaccess'],
        ];

        foreach ($tasks as $task) {
            try {
                $this->{$task['method']}();
            } catch (\Exception $e) {
                \Log::warning("Post-install task '{$task['name']}' failed: " . $e->getMessage());
            }
        }
    }

    /**
     * Verify .htaccess exists and is properly configured
     */
    protected function verifyHtaccess()
    {
        $htaccessPath = public_path('.htaccess');
        
        if (!file_exists($htaccessPath)) {
            // Create basic .htaccess if missing
            $htaccessContent = <<<'HTACCESS'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
HTACCESS;
            @file_put_contents($htaccessPath, $htaccessContent);
        }
    }

    /**
     * Generate production caches (config, routes, views)
     */
    protected function generateProductionCaches()
    {
        try {
            // Generate config cache
            Artisan::call('config:cache');
            
            // Generate route cache
            Artisan::call('route:cache');
            
            // Note: view cache is generated automatically on first access
        } catch (\Exception $e) {
            // If caching fails, just log it - not critical
            \Log::warning('Could not generate production caches: ' . $e->getMessage());
        }
    }

    /**
     * Ensure all required directories exist with proper structure
     */
    protected function ensureDirectoriesExist()
    {
        $directories = [
            storage_path('app/public'),
            storage_path('app/public/products'),
            storage_path('app/public/uploads'),
            storage_path('framework/cache'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('logs'),
            public_path('storage'),
        ];

        foreach ($directories as $dir) {
            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
        }
    }

    /**
     * Check file permissions and create info file if issues found
     */
    protected function checkFilePermissions()
    {
        $checks = [
            'storage' => is_writable(storage_path()),
            'bootstrap_cache' => is_writable(base_path('bootstrap/cache')),
            'public' => is_writable(public_path()),
        ];

        $hasIssues = in_array(false, $checks);
        
        if ($hasIssues) {
            $message = "Some directories need write permissions:\n\n";
            
            if (!$checks['storage']) {
                $message .= "- storage/ (755 or 775)\n";
            }
            if (!$checks['bootstrap_cache']) {
                $message .= "- bootstrap/cache/ (755 or 775)\n";
            }
            if (!$checks['public']) {
                $message .= "- public/ (755)\n";
            }
            
            $message .= "\nPlease set these permissions via File Manager or contact hosting support.";
            
            @file_put_contents(base_path('PERMISSIONS_REQUIRED.txt'), $message);
        }
    }

    public function render()
    {
        return view('livewire.installer')->layout('components.layouts.app');
    }
}
