<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'value' => 10,
                'min_spend' => 500,
                'max_uses' => 1000,
                'used_count' => 45,
                'expires_at' => now()->addYear(),
                'is_active' => true,
            ],
            [
                'code' => 'FLAT200',
                'type' => 'fixed',
                'value' => 200,
                'min_spend' => 1500,
                'max_uses' => 500,
                'used_count' => 120,
                'expires_at' => now()->addMonths(6),
                'is_active' => true,
            ],
            [
                'code' => 'SUMMER50',
                'type' => 'percentage',
                'value' => 50,
                'min_spend' => 2000,
                'max_uses' => 100,
                'used_count' => 100,
                'expires_at' => now()->subDay(), // Expired
                'is_active' => false,
            ],
            [
                'code' => 'FLASH30',
                'type' => 'percentage',
                'value' => 30,
                'min_spend' => 1000,
                'max_uses' => 50,
                'used_count' => 12,
                'expires_at' => now()->addDays(2),
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::updateOrCreate(
                ['code' => $coupon['code']],
                $coupon
            );
        }
    }
}
