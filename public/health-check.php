<?php
/**
 * System Health Check
 * Upload to public/ folder and visit: https://style91.com/health-check.php
 * DELETE after use for security
 */

echo "<h1>Style91 System Health Check</h1>";
echo "<hr>";

// 1. Check Laravel Bootstrap
try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    echo "✅ Laravel Bootstrap: OK<br>";
} catch (\Exception $e) {
    echo "❌ Laravel Bootstrap: FAILED<br>";
    echo "Error: " . $e->getMessage() . "<br>";
    die();
}

// 2. Check Database Connection
try {
    DB::connection()->getPdo();
    echo "✅ Database Connection: OK<br>";
} catch (\Exception $e) {
    echo "❌ Database Connection: FAILED<br>";
    echo "Error: " . $e->getMessage() . "<br>";
}

// 3. Check Required Tables
$tables = ['users', 'products', 'categories', 'sections'];
foreach ($tables as $table) {
    try {
        DB::table($table)->count();
        echo "✅ Table '$table': EXISTS<br>";
    } catch (\Exception $e) {
        echo "❌ Table '$table': MISSING<br>";
    }
}

// 4. Check Views
$views = [
    'livewire.home',
    'livewire.auth.admin-login',
    'components.layouts.app',
];
foreach ($views as $view) {
    try {
        view()->exists($view);
        echo "✅ View '$view': EXISTS<br>";
    } catch (\Exception $e) {
        echo "❌ View '$view': ERROR<br>";
    }
}

// 5. Check Storage Permissions
$writeable = is_writable(storage_path());
echo $writeable ? "✅ Storage: WRITEABLE<br>" : "❌ Storage: NOT WRITEABLE<br>";

// 6. Check .env
echo file_exists(base_path('.env')) ? "✅ .env File: EXISTS<br>" : "❌ .env File: MISSING<br>";

// 7. Check Caches
echo "<hr><h2>Clearing Caches...</h2>";
try {
    Artisan::call('view:clear');
    echo "✅ View cache cleared<br>";
    Artisan::call('config:clear');
    echo "✅ Config cache cleared<br>";
    Artisan::call('cache:clear');
    echo "✅ Application cache cleared<br>";
} catch (\Exception $e) {
    echo "❌ Cache clear failed: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<p style='color: red;'><strong>DELETE THIS FILE NOW!</strong></p>";
echo "<p><a href='/'>Go to Homepage</a></p>";
