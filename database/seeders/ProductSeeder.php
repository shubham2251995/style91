<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure categories exist first
        $tshirt = \App\Models\Category::where('name', 'T-Shirts')->first();
        $hoodie = \App\Models\Category::where('name', 'Hoodies')->first();
        $jogger = \App\Models\Category::where('name', 'Joggers')->first();
        $sneaker = \App\Models\Category::where('name', 'Sneakers')->first();
        $accessory = \App\Models\Category::where('name', 'Accessories')->first();

        // Fallback if categories not seeded
        if (!$tshirt) return;

        $products = [
            [
                'name' => 'Tokyo Rebels Oversized Tee',
                'slug' => 'tokyo-rebels-oversized-tee',
                'price' => 799.00,
                'stock_quantity' => 50,
                'description' => 'Premium 100% cotton oversized fit tee with exclusive Tokyo street art graphic. Dropped shoulders, longer length. Perfect for that effortless streetwear vibe.',
                'image_url' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=600',
                'category_id' => $tshirt->id,
            ],
            [
                'name' => 'Minimalist Vibes Hoodie',
                'slug' => 'minimalist-vibes-hoodie',
                'price' => 1499.00,
                'stock_quantity' => 30,
                'description' => 'Heavyweight 400GSM hoodie with super soft fleece lining. Features minimalist embroidered logo and kangaroo pocket. Your new go-to comfort piece.',
                'image_url' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=600',
                'category_id' => $hoodie->id,
            ],
            [
                'name' => 'Astro Panda Graphic Tee',
                'slug' => 'astro-panda-graphic-tee',
                'price' => 699.00,
                'stock_quantity' => 75,
                'description' => 'Quirky panda astronaut print on premium fabric. Regular fit, crew neck, tagless for extra comfort. Because why should pandas miss out on space exploration?',
                'image_url' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600',
                'category_id' => $tshirt->id,
            ],
            [
                'name' => 'Vibe Check Joggers',
                'slug' => 'vibe-check-joggers',
                'price' => 1199.00,
                'stock_quantity' => 40,
                'description' => 'Super soft cotton-blend terry joggers with elastic waistband and cuffed ankles. Side pockets + back pocket. Ultimate comfort for chilling or working out.',
                'image_url' => 'https://images.unsplash.com/photo-1555689502-c4b22d76c56f?w=600',
                'category_id' => $jogger->id,
            ],
            
            // Veirdo Style - Edgy & Experimental
            [
                'name' => 'Toxic Venom All-Over Print Tee',
                'slug' => 'toxic-venom-print-tee',
                'price' => 899.00,
                'stock_quantity' => 35,
                'description' => 'Bold all-over toxic drip print. Premium quality fabric with unique neon green accents. For those who dare to stand out. Not for the faint-hearted.',
                'image_url' => 'https://images.unsplash.com/photo-1562157873-818bc0726f68?w=600',
                'category_id' => $tshirt->id,
            ],
            [
                'name' => 'Chaos Theory Zipper Hoodie',
                'slug' => 'chaos-theory-zipper-hoodie',
                'price' => 1799.00,
                'stock_quantity' => 25,
                'description' => 'Black zipper hoodie with abstract chaos print. Heavy-duty YKK zipper, reinforced stitching, deep hood. Where madness meets method.',
                'image_url' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=600',
                'category_id' => $hoodie->id,
            ],
            [
                'name' => 'Neon Nights Distressed Tee',
                'slug' => 'neon-nights-distressed-tee',
                'price' => 849.00,
                'stock_quantity' => 45,
                'description' => 'Pre-distressed vintage wash tee with neon typography. Each piece is unique. Embrace the imperfections.',
                'image_url' => 'https://images.unsplash.com/photo-1503341504253-dff4815485f1?w=600',
                'category_id' => $tshirt->id,
            ],
            [
                'name' => 'Midnight Cargo Pants',
                'slug' => 'midnight-cargo-pants',
                'price' => 1599.00,
                'stock_quantity' => 30,
                'description' => 'Tactical-inspired cargo pants with multiple utility pockets, adjustable straps, and reinforced knees. Built for the urban explorer.',
                'image_url' => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=600',
                'category_id' => $jogger->id,
            ],

            // Bestsellers
            [
                'name' => 'Classic White Crew Neck',
                'slug' => 'classic-white-crew-neck',
                'price' => 599.00,
                'stock_quantity' => 100,
                'description' => 'The perfect white tee. Premium 180GSM cotton, regular fit, reinforced collar. A wardrobe essential that never goes out of style.',
                'image_url' => 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?w=600',
                'category_id' => $tshirt->id,
            ],
            [
                'name' => 'Chill Zone Shorts',
                'slug' => 'chill-zone-shorts',
                'price' => 799.00,
                'stock_quantity' => 55,
                'description' => 'Lightweight cotton shorts with elastic waistband and drawstring. Side pockets and back pocket with button closure. Perfect for summer vibes.',
                'image_url' => 'https://images.unsplash.com/photo-1591195853828-11db59a44f6b?w=600',
                'category_id' => $jogger->id,
            ],
            [
                'name' => 'Urban Sneaker Collection',
                'slug' => 'urban-sneaker-white',
                'price' => 2499.00,
                'stock_quantity' => 20,
                'description' => 'Clean white sneakers with minimal branding. Breathable mesh upper, cushioned sole, premium laces. Pairs with everything.',
                'image_url' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=600',
                'category_id' => $sneaker ? $sneaker->id : $tshirt->id,
            ],

            // Limited Edition
            [
                'name' => 'Pride Collection Rainbow Tee',
                'slug' => 'pride-rainbow-tee',
                'price' => 999.00,
                'stock_quantity' => 15,
                'description' => 'Limited edition Pride month exclusive. Rainbow gradient print with love = love messaging. ₹100 from each sale donated to LGBTQ+ charities.',
                'image_url' => 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=600',
                'category_id' => $tshirt->id,
            ],
            [
                'name' => 'Biodegradable Earth Tee',
                'slug' => 'biodegradable-earth-tee',
                'price' => 1099.00,
                'stock_quantity' => 25,
                'description' => 'Made from 100% organic biodegradable fabric. Earth graphic print with eco-friendly inks. Fashion that cares for the planet.',
                'image_url' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=600',
                'category_id' => $tshirt->id,
            ],
            [
                'name' => 'Glow In Dark Alien Hoodie',
                'slug' => 'glow-in-dark-alien-hoodie',
                'price' => 1999.00,
                'stock_quantity' => 18,
                'description' => 'Epic glow-in-the-dark alien graphic. Heavy fleece hoodie with ribbed cuffs and hem. Watch it come alive in the dark!',
                'image_url' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=600',
                'category_id' => $hoodie->id,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrInsert(
                ['slug' => $product['slug']], // Match by slug
                $product // Insert/Update data
            );
        }
    }
}
