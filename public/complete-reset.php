<?php
/**
 * COMPLETE SITE RESET SCRIPT
 * This will fix EVERYTHING
 * 
 * 1. Upload this file to: public/complete-reset.php
 * 2. Visit: https://style91.com/complete-reset.php
 * 3. Follow the instructions
 * 4. DELETE this file after use
 */

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "<h1>🔧 Complete Site Reset</h1>";
echo "<hr>";

// Step 1: Clear ALL caches
echo "<h2>Step 1: Clearing Caches...</h2>";
try {
    Artisan::call('view:clear');
    echo "✅ View cache cleared<br>";
    
    Artisan::call('config:clear');
    echo "✅ Config cache cleared<br>";
    
    Artisan::call('cache:clear');
    echo "✅ Application cache cleared<br>";
    
    Artisan::call('route:clear');
    echo "✅ Route cache cleared<br>";
} catch (\Exception $e) {
    echo "❌ Error clearing caches: " . $e->getMessage() . "<br>";
}

// Step 2: Check critical files
echo "<hr><h2>Step 2: Checking Files...</h2>";

$criticalFiles = [
    'resources/views/components/layouts/app.blade.php' => 'Main Layout',
    'resources/views/livewire/home.blade.php' => 'Homepage View',
    'app/Livewire/Home.php' => 'Homepage Controller',
];

foreach ($criticalFiles as $file => $name) {
    $fullPath = base_path($file);
    if (file_exists($fullPath)) {
        echo "✅ $name exists<br>";
    } else {
        echo "❌ $name MISSING<br>";
    }
}

// Step 3: Test layout rendering
echo "<hr><h2>Step 3: Testing Layout...</h2>";
try {
    $layoutExists = view()->exists('components.layouts.app');
    echo $layoutExists ? "✅ App layout can be loaded<br>" : "❌ App layout cannot be loaded<br>";
} catch (\Exception $e) {
    echo "❌ Layout error: " . $e->getMessage() . "<br>";
}

// Step 4: Check Livewire
echo "<hr><h2>Step 4: Checking Livewire...</h2>";
try {
    if (class_exists('\App\Livewire\Home')) {
        echo "✅ Home Livewire component exists<br>";
    } else {
        echo "❌ Home Livewire component missing<br>";
    }
} catch (\Exception $e) {
    echo "❌ Livewire error: " . $e->getMessage() . "<br>";
}

// Step 5: Instructions
echo "<hr><h2>📋 What To Do Next:</h2>";

echo "<div style='background: #fff3cd; padding: 15px; border-left: 4px solid #ffc107;'>";
echo "<h3>If you see ❌ errors above:</h3>";
echo "<ol>";
echo "<li>The listed files are MISSING from your server</li>";
echo "<li>You need to upload them from your local development</li>";
echo "<li>Make sure you upload to the CORRECT directories</li>";
echo "</ol>";
echo "</div>";

echo "<div style='background: #d1ecf1; padding: 15px; border-left: 4px solid #0c5460; margin-top: 20px;'>";
echo "<h3>If everything shows ✅:</h3>";
echo "<ol>";
echo "<li>Caches are cleared</li>";
echo "<li>Files are in place</li>";
echo "<li><strong><a href='/'>Visit Homepage Now →</a></strong></li>";
echo "</ol>";
echo "</div>";

echo "<hr>";
echo "<p style='color: red; font-weight: bold;'>🚨 DELETE THIS FILE (complete-reset.php) IMMEDIATELY FOR SECURITY!</p>";
