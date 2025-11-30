<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

echo "Starting Codebase Audit...\n";

// 1. Get all defined routes
$definedRoutes = [];
foreach (Route::getRoutes() as $route) {
    if ($name = $route->getName()) {
        $definedRoutes[] = $name;
    }
}
echo "Found " . count($definedRoutes) . " defined routes.\n";

// 2. Scan Blade files
$viewsPath = resource_path('views');
$files = File::allFiles($viewsPath);

$errors = [];
$warnings = [];

foreach ($files as $file) {
    $content = file_get_contents($file->getRealPath());
    $relativePath = str_replace($viewsPath . DIRECTORY_SEPARATOR, '', $file->getRealPath());

    // Check for unbalanced directives
    $directives = ['if', 'foreach', 'auth', 'guest', 'section', 'push', 'php'];
    
    foreach ($directives as $directive) {
        // Simple regex count (not perfect but good for catching obvious errors)
        // We look for @directive and @enddirective
        // Note: @section can be self-closing or not, so it's tricky. @section('name') vs @section('name', 'content')
        // But usually @section without comma needs @endsection.
        
        if ($directive === 'section') {
            // Count @section that are NOT followed by a comma (approximate)
            // This is hard to regex perfectly. Let's skip section for now or be careful.
            continue; 
        }

        $openCount = preg_match_all('/@' . $directive . '\b/', $content);
        $closeCount = preg_match_all('/@end' . $directive . '\b/', $content);

        if ($openCount !== $closeCount) {
            $errors[] = "[Blade Syntax] $relativePath: Mismatched @$directive ($openCount) vs @end$directive ($closeCount)";
        }
    }

    // Check for undefined routes
    if (preg_match_all("/route\(['\"]([^'\"]+)['\"]/", $content, $matches)) {
        foreach ($matches[1] as $routeName) {
            if (!in_array($routeName, $definedRoutes)) {
                // Ignore some dynamic routes or common false positives if needed
                $warnings[] = "[Undefined Route] $relativePath: route('$routeName') not found.";
            }
        }
    }

    // Check for @vite usage
    if (strpos($content, '@vite') !== false) {
        $warnings[] = "[Vite Usage] $relativePath: Contains @vite directive (check if safe for production).";
    }
}

$results = [
    'errors' => $errors,
    'warnings' => $warnings,
    'defined_routes' => count($definedRoutes)
];

file_put_contents('audit_results.json', json_encode($results, JSON_PRETTY_PRINT));
echo "Audit complete. Results written to audit_results.json\n";
