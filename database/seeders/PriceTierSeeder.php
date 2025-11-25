<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PriceTier;

class PriceTierSeeder extends Seeder
{
    public function run(): void
    {
        $tiers = [
            ['product_id' => null, 'min_quantity' => 10, 'discount_percentage' => 10.00],
            ['product_id' => null, 'min_quantity' => 25, 'discount_percentage' => 15.00],
            ['product_id' => null, 'min_quantity' => 50, 'discount_percentage' => 20.00],
            ['product_id' => null, 'min_quantity' => 100, 'discount_percentage' => 25.00],
        ];

        foreach ($tiers as $tier) {
            PriceTier::updateOrCreate(
                ['product_id' => $tier['product_id'], 'min_quantity' => $tier['min_quantity']],
                $tier
            );
        }
    }
}
