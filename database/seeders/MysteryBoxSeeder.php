<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MysteryBox;
use App\Models\Product;
use Illuminate\Support\Str;

class MysteryBoxSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        if ($products->count() < 3) return;

        // Box 1: The Starter Pack
        $box1 = MysteryBox::create([
            'name' => 'Starter Hype Box',
            'slug' => 'starter-hype-box',
            'description' => 'A perfect entry into the world of streetwear. Contains 1 guaranteed item.',
            'price' => 49.99,
            'image_url' => 'https://images.unsplash.com/photo-1513885535751-8b9238bd345a?auto=format&fit=crop&w=800&q=80',
            'status' => 'active',
        ]);

        $box1->items()->create(['product_id' => $products->random()->id, 'probability' => 60]);
        $box1->items()->create(['product_id' => $products->random()->id, 'probability' => 30]);
        $box1->items()->create(['product_id' => $products->random()->id, 'probability' => 10]);

        // Box 2: The Grail Box
        $box2 = MysteryBox::create([
            'name' => 'The Grail Box',
            'slug' => 'grail-box',
            'description' => 'High risk, high reward. Chance to win exclusive limited edition items.',
            'price' => 199.99,
            'image_url' => 'https://images.unsplash.com/photo-1607522370275-f14bc3b531df?auto=format&fit=crop&w=800&q=80',
            'status' => 'active',
        ]);

        $box2->items()->create(['product_id' => $products->random()->id, 'probability' => 80]);
        $box2->items()->create(['product_id' => $products->random()->id, 'probability' => 15]);
        $box2->items()->create(['product_id' => $products->random()->id, 'probability' => 5]);
    }
}
