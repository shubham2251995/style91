<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    public function run()
    {
        $gateways = [
            [
                'name' => 'Razorpay',
                'code' => 'razorpay',
                'description' => 'Pay securely with Credit/Debit Card, UPI, Netbanking',
                'is_active' => true,
                'config' => [
                    'api_key' => 'rzp_test_1234567890',
                    'api_secret' => 'secret_1234567890',
                ],
                'display_order' => 1,
            ],
            [
                'name' => 'Cashfree',
                'code' => 'cashfree',
                'description' => 'Pay via Cashfree Payments',
                'is_active' => true,
                'config' => [
                    'app_id' => 'test_app_id',
                    'secret_key' => 'test_secret_key',
                ],
                'display_order' => 2,
            ],
            [
                'name' => 'Cash on Delivery',
                'code' => 'cod',
                'description' => 'Pay with cash upon delivery',
                'is_active' => true,
                'config' => [],
                'display_order' => 3,
            ],
        ];

        foreach ($gateways as $gateway) {
            PaymentGateway::updateOrCreate(
                ['code' => $gateway['code']],
                $gateway
            );
        }
    }
}
