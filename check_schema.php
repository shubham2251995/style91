<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$shippingExists = \Illuminate\Support\Facades\Schema::hasTable('shipping_methods');
echo "Table shipping_methods exists: " . ($shippingExists ? 'Yes' : 'No') . "\n";

$genderExists = \Illuminate\Support\Facades\Schema::hasColumn('products', 'gender');
echo "Column products.gender exists: " . ($genderExists ? 'Yes' : 'No') . "\n";
