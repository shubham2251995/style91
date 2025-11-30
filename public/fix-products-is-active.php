<?php
/**
 * Production Database Fix Script
 * Run this on production after deployment to add missing is_active column
 */

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "==========================================\n";
echo "Production Database Fix - Adding is_active\n";
echo "==========================================\n\n";

try {
    // Run the specific migration
    echo "Running migration: add_is_active_to_products_table...\n";
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_11_30_152800_add_is_active_to_products_table.php',
        '--force' => true
    ]);
    
    $output = Artisan::output();
    echo $output;
    
    // Verify the column exists
    if (Schema::hasColumn('products', 'is_active')) {
        echo "\n✅ SUCCESS: is_active column added to products table\n";
        
        // Update all existing products to be active
        $count = DB::table('products')->whereNull('is_active')->update(['is_active' => true]);
        echo "✅ Updated $count products to is_active = true\n";
    } else {
        echo "\n❌ ERROR: is_active column not found after migration\n";
        exit(1);
    }
    
    // Clear caches
    echo "\nClearing caches...\n";
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    echo "✅ Caches cleared\n";
    
    echo "\n==========================================\n";
    echo "Fix completed successfully!\n";
    echo "==========================================\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
