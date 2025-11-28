<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$exists = \Illuminate\Support\Facades\Schema::hasTable('addresses');
echo "Table addresses exists: " . ($exists ? 'Yes' : 'No');
