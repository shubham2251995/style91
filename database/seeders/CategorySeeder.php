<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'T-Shirts',
                'description' => 'Premium cotton tees with unique graphic prints and oversized fits.',
                'image_url' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600&q=80',
                'display_order' => 1,
            ],
            [
                'name' => 'Hoodies',
                'description' => 'Heavyweight fleece hoodies perfect for layering and comfort.',
                'image_url' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=600&q=80',
                'display_order' => 2,
            ],
            [
                'name' => 'Joggers',
                'description' => 'Comfortable joggers and cargo pants for the urban explorer.',
                'image_url' => 'https://images.unsplash.com/photo-1555689502-c4b22d76c56f?w=600&q=80',
                'display_order' => 3,
            ],
            [
                'name' => 'Jackets',
                'description' => 'Bomber jackets, windbreakers, and denim layers.',
                'image_url' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600&q=80',
                'display_order' => 4,
            ],
            [
                'name' => 'Sneakers',
                'description' => 'Limited edition kicks and everyday essentials.',
                'image_url' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=600&q=80',
                'display_order' => 5,
            ],
            [
                'name' => 'Accessories',
                'description' => 'Complete your look with caps, bags, and jewelry.',
                'image_url' => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?w=600&q=80',
                'display_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                array_merge($category, ['is_active' => true])
            );
        }
    }
}
