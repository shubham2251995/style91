<?php
/**
 * EMERGENCY CACHE CLEANER
 * Visit this file directly to clear ALL Laravel caches
 * Usage: https://yourdomain.com/clear-everything.php
 */

// Clear config cache
$configPath = __DIR__ . '/../bootstrap/cache/config.php';
if (file_exists($configPath)) {
    unlink($configPath);
    echo "✅ Config cache cleared<br>";
} else {
    echo "ℹ️ No config cache found<br>";
}

// Clear route cache
$routePath = __DIR__ . '/../bootstrap/cache/routes-v7.php';
if (file_exists($routePath)) {
    unlink($routePath);
    echo "✅ Route cache cleared<br>";
}

// Clear all compiled views
$viewsPath = __DIR__ . '/../storage/framework/views';
if (is_dir($viewsPath)) {
    $files = glob($viewsPath . '/*');
    foreach($files as $file) {
        if(is_file($file)) {
            unlink($file);
        }
    }
    echo "✅ View cache cleared<br>";
}

// Clear application cache
$cachePath = __DIR__ . '/../storage/framework/cache/data';
if (is_dir($cachePath)) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($cachePath, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($files as $fileinfo) {
        $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
        $todo($fileinfo->getRealPath());
    }
    echo "✅ Application cache cleared<br>";
}

echo "<br><strong>✅ ALL CACHES CLEARED!</strong><br>";
echo "Now visit: <a href='/install'>/install</a><br><br>";
echo "<small>⚠️ DELETE THIS FILE after installation for security!</small>";
