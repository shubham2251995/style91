<?php
/**
 * Verification Script for Codebase Audit Fixes
 * Run this after deploying all fixes to verify everything is working
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "===========================================\n";
echo "STYLE91 - Codebase Verification Script\n";
echo "===========================================\n\n";

// 1. Check Route Definitions
echo "1. Checking Route Definitions...\n";
$router = app('router');
$routes = $router->getRoutes();
$routeNames = [];
foreach ($routes as $route) {
    if ($name = $route->getName()) {
        $routeNames[] = $name;
    }
}

$requiredRoutes = ['search', 'cart', 'plugin.fit-check.upload', 'plugin.vote', 'gift-cards.purchase'];
$missing = [];
foreach ($requiredRoutes as $routeName) {
    if (!in_array($routeName, $routeNames)) {
        $missing[] = $routeName;
    }
}

if (empty($missing)) {
    echo "   ✓ All critical routes are defined (" . count($routeNames) . " total routes)\n\n";
} else {
    echo "   ✗ Missing routes: " . implode(', ', $missing) . "\n\n";
}

// 2. Check Blade Files
echo "2. Checking Critical Blade Files...\n";
$bladeFiles = [
    'address-manager.blade.php' => 'resources/views/livewire/address-manager.blade.php',
    'footer-vibrant.blade.php' => 'resources/views/components/footer-vibrant.blade.php',
    'header-vibrant.blade.php' => 'resources/views/components/header-vibrant.blade.php',
];

foreach ($bladeFiles as $name => $path) {
    $fullPath = base_path($path);
    if (file_exists($fullPath)) {
        $content = file_get_contents($fullPath);
        // Check for common issues
        if (strpos($name, 'footer') !== false && strpos($content, "route('products.index')") !== false) {
            echo "   ✗ $name still has route('products.index')\n";
        } elseif (strpos($name, 'header') !== false && strpos($content, "route('cart.index')") !== false) {
            echo "   ✗ $name still has route('cart.index')\n";
        } else {
            echo "   ✓ $name looks good\n";
        }
    } else {
        echo "   ✗ $name not found\n";
    }
}

echo "\n3. Database Connection...\n";
try {
    DB::connection()->getPdo();
    $dbName = DB::connection()->getDatabaseName();
    echo "   ✓ Connected to database: $dbName\n";
} catch (\Exception $e) {
    echo "   ✗ Database connection failed: " . $e->getMessage() . "\n";
}

echo "\n4. Environment Check...\n";
echo "   APP_ENV: " . config('app.env') . "\n";
echo "   APP_DEBUG: " . (config('app.debug') ? 'true' : 'false') . "\n";
echo "   DB_DATABASE: " . config('database.connections.mysql.database') . "\n";

echo "\n===========================================\n";
echo "Verification Complete!\n";
echo "===========================================\n";
