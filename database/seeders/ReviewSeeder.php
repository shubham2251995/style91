<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'customer')->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        $reviews = [
            'Amazing quality! Fits perfectly.',
            'Love the design, but shipping took a bit long.',
            'Best purchase I made this year. Highly recommended!',
            'Fabric is super soft. Will buy again.',
            'Not bad, but size runs a bit small.',
            'Absolutely fire! 🔥',
            'Great value for money.',
            'The print quality is top notch.',
        ];

        foreach ($products as $product) {
            // Add 0-3 reviews per product
            $reviewCount = rand(0, 3);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                $user = $users->random();
                
                Review::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'rating' => rand(3, 5),
                    'comment' => $reviews[array_rand($reviews)],
                    'is_approved' => true,
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}
