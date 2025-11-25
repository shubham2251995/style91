<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lookbook;
use App\Models\LookbookItem;
use App\Models\Product;

class LookbookSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        if ($products->isEmpty()) return;

        $lookbook = Lookbook::create([
            'title' => 'SUMMER 2025: CONCRETE JUNGLE',
            'slug' => 'summer-2025',
            'description' => 'Navigating the heat of the city with style.',
            'cover_image_url' => 'https://images.unsplash.com/photo-1523398002811-999ca8dec234?auto=format&fit=crop&w=800&q=80',
            'is_active' => true,
        ]);

        // Item 1
        LookbookItem::create([
            'lookbook_id' => $lookbook->id,
            'product_id' => $products->random()->id,
            'image_url' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80',
            'x_position' => 45,
            'y_position' => 30,
            'order' => 1,
        ]);

        // Item 2
        LookbookItem::create([
            'lookbook_id' => $lookbook->id,
            'product_id' => $products->random()->id,
            'image_url' => 'https://images.unsplash.com/photo-1529139574466-a302c27e0169?auto=format&fit=crop&w=800&q=80',
            'x_position' => 60,
            'y_position' => 50,
            'order' => 2,
        ]);

        // Item 3
        LookbookItem::create([
            'lookbook_id' => $lookbook->id,
            'product_id' => $products->random()->id,
            'image_url' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=800&q=80',
            'x_position' => 30,
            'y_position' => 60,
            'order' => 3,
        ]);
    }
}
