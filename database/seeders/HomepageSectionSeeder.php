<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomepageSection;

class HomepageSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'type' => 'hero',
                'title' => 'Welcome Hero',
                'content' => [
                    'image_url' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=2000&q=80',
                    'title' => "STREETWEAR REVOLUTION",
                    'subtitle' => 'Drop Culture Meets Street Style',
                    'cta_text' => 'Shop Now',
                    'cta_url' => '/',
                ],
                'order' => 0,
                'is_active' => true,
            ],
            [
                'type' => 'categories',
                'title' => 'Shop by Category',
                'content' => [
                    'categories' => [
                        ['name' => 'T-Shirts', 'url' => '/', 'image_url' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&q=80'],
                        ['name' => 'Hoodies', 'url' => '/', 'image_url' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=400&q=80'],
                        ['name' => 'Joggers', 'url' => '/', 'image_url' => 'https://images.unsplash.com/photo-1555689502-c4b22d76c56f?w=400&q=80'],
                        ['name' => 'Accessories', 'url' => '/', 'image_url' => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?w=400&q=80'],
                        ['name' => 'Sneakers', 'url' => '/', 'image_url' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400&q=80'],
                        ['name' => 'Jackets', 'url' => '/', 'image_url' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400&q=80'],
                        ['name' => 'Caps', 'url' => '/', 'image_url' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=400&q=80'],
                        ['name' => 'Backpacks', 'url' => '/', 'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&q=80'],
                    ],
                ],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'type' => 'banner',
                'title' => null,
                'content' => [
                    'badge' => 'LIMITED DROP',
                    'title' => 'URBAN<br>LEGENDS',
                    'subtitle' => 'Exclusive Streetwear Collection',
                    'cta_text' => 'VIEW COLLECTION',
                    'cta_url' => '/',
                    'image_url' => 'https://images.unsplash.com/photo-1529720317453-c8da503f2051?w=400&q=80',
                ],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'type' => 'featured_products',
                'title' => 'New Drops',
                'content' => [
                    'product_filter' => 'latest',
                    'limit' => 4,
                    'view_all_url' => '/',
                ],
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            HomepageSection::updateOrCreate(
                ['type' => $section['type'], 'order' => $section['order']],
                $section
            );
        }
    }
}
