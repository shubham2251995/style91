<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

echo "Menus table exists: " . (Schema::hasTable('menus') ? 'Yes' : 'No') . "\n";
echo "Menu Items table exists: " . (Schema::hasTable('menu_items') ? 'Yes' : 'No') . "\n";
