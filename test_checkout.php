<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $component = new \App\Livewire\Checkout\CheckoutAddress();
    echo "Component instantiated successfully.\n";
    
    // Simulate mount
    $component->mount();
    echo "Mount successful.\n";
    
    // Simulate render
    $view = $component->render();
    echo "Render successful.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
