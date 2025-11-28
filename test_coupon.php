<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Coupon;
use App\Services\CouponService;

try {
    // Create a dummy coupon
    $coupon = new Coupon([
        'code' => 'TEST10',
        'type' => 'percentage',
        'value' => 10,
        'is_active' => true,
        'expires_at' => now()->addDay(),
    ]);
    
    // Mock the service
    $service = new CouponService();
    
    // Test validation (mocking database query by just testing logic if possible, 
    // but service queries DB. So we might need to insert it or mock the facade.
    // For simplicity, we'll just test the calculateDiscount method which is pure logic 
    // and validate method if we can insert a coupon.)
    
    // Let's just test calculateDiscount
    $total = 1000;
    $discount = $service->calculateDiscount($coupon, $total);
    echo "Total: $total, Discount (10%): $discount\n";
    
    if ($discount == 100) {
        echo "Calculation Correct.\n";
    } else {
        echo "Calculation Failed.\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
