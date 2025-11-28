<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ShippingMethod;
use App\Models\ShippingZone;
use App\Services\ShippingService;

try {
    // Clean up previous test data if any (optional, but good for idempotency)
    // For now, we'll just create new ones and assume DB reset or unique names if needed.
    
    // Create a Method
    $method = ShippingMethod::firstOrCreate(
        ['name' => 'Test Express'],
        [
            'description' => 'Fast delivery',
            'cost' => 100,
            'is_active' => true,
            'display_order' => 1
        ]
    );
    
    // Create a Zone for "IN" (India)
    $zone = ShippingZone::firstOrCreate(
        ['name' => 'India Zone'],
        [
            'countries' => ['IN'],
            'is_active' => true
        ]
    );
    
    // Attach method to zone with override
    if (!$zone->shippingMethods()->where('shipping_method_id', $method->id)->exists()) {
        $zone->shippingMethods()->attach($method->id, [
            'cost_override' => 50, // Cheaper in India
            'is_enabled' => true
        ]);
    }
    
    $service = new ShippingService();
    
    // Test 1: Address in Zone (IN)
    echo "Testing Address in IN...\n";
    $methods = $service->getAvailableMethods('IN');
    $found = $methods->firstWhere('id', $method->id);
    
    if ($found) {
        echo "Method found.\n";
        $cost = $service->calculateCost($found, 'IN');
        echo "Cost: $cost (Expected: 50)\n";
    } else {
        echo "Method NOT found.\n";
    }
    
    // Test 2: Address NOT in Zone (US)
    echo "\nTesting Address in US...\n";
    $methodsUS = $service->getAvailableMethods('US');
    $foundUS = $methodsUS->firstWhere('id', $method->id);
    
    if ($foundUS) {
        echo "Method found (Should not be if it's zone restricted? Wait, logic says if no zone matches, return global methods. Is this method global? No, it's in a zone. But is it ONLY in a zone? The logic says: if matchingZones is empty, return methods that dont have zones. This method HAS zones. So it should NOT be returned for US if US doesn't match the zone.)\n";
    } else {
        echo "Method NOT found (Correct).\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
