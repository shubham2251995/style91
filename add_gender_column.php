<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    \Illuminate\Support\Facades\DB::statement("ALTER TABLE products ADD COLUMN gender VARCHAR(255) DEFAULT 'Unisex'");
    echo "Column gender added successfully.";
} catch (\Exception $e) {
    echo "Error adding column: " . $e->getMessage();
}
