<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FitCheck;
use App\Models\User;
use App\Models\Product;

class FitCheckSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) return;

        FitCheck::create([
            'user_id' => $users->random()->id,
            'image_url' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80',
            'caption' => 'Friday fit check. Feeling the vibe.',
            'tagged_products' => [$products->random()->id],
            'likes' => rand(10, 100),
        ]);

        FitCheck::create([
            'user_id' => $users->random()->id,
            'image_url' => 'https://images.unsplash.com/photo-1529139574466-a302c27e0169?auto=format&fit=crop&w=800&q=80',
            'caption' => 'New drop is insane! 🔥',
            'tagged_products' => [$products->random()->id],
            'likes' => rand(50, 200),
        ]);
    }
}
