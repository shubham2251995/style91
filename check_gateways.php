<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$gateways = \App\Models\PaymentGateway::all();
echo "Payment Gateways count: " . $gateways->count() . "\n";
foreach ($gateways as $gateway) {
    echo "- " . $gateway->name . " (" . $gateway->code . ") Active: " . ($gateway->is_active ? 'Yes' : 'No') . "\n";
}
