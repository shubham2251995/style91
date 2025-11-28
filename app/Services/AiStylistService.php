<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class AiStylistService
{
    public function completeTheLook(Product $product, $limit = 3)
    {
        // Simple rule-based "AI" for now
        // 1. Find products in complementary categories
        // 2. Match style tags
        // 3. Exclude current product
        
        $categoryMap = [
            'T-Shirts' => ['Pants', 'Jackets', 'Accessories'],
            'Pants' => ['T-Shirts', 'Hoodies', 'Sneakers'],
            'Hoodies' => ['Jeans', 'Joggers', 'Caps'],
            'Sneakers' => ['Socks', 'Pants', 'Shorts'],
        ];

        $currentCategory = $product->category->name ?? '';
        $complementaryCategories = $categoryMap[$currentCategory] ?? [];

        $query = Product::where('id', '!=', $product->id)
            ->where('stock_quantity', '>', 0);

        if (!empty($complementaryCategories)) {
            $query->whereHas('category', function($q) use ($complementaryCategories) {
                $q->whereIn('name', $complementaryCategories);
            });
        } else {
            // Fallback: same category or random
            $query->inRandomOrder();
        }

        // Tag matching (bonus score)
        // For simplicity, just get random complementary products for now
        return $query->inRandomOrder()->take($limit)->get();
    }

    public function getPersonalizedRecommendations($userId, $limit = 4)
    {
        // Mock personalization based on user history
        return Product::inRandomOrder()->take($limit)->get();
    }
}
