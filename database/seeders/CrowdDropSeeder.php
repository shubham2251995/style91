<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CrowdDrop;
use App\Models\Product;

class CrowdDropSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::inRandomOrder()->first();
        if (!$product) return;

        CrowdDrop::create([
            'product_id' => $product->id,
            'start_price' => $product->price,
            'current_price' => $product->price,
            'min_price' => $product->price * 0.5, // Can drop to 50% off
            'drop_amount' => 2.00, // Drops $2 per person
            'expires_at' => now()->addDays(2),
            'status' => 'active',
        ]);
    }
}
