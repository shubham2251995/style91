<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;
use App\Models\HeroSlide;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Hero Slides
        HeroSlide::create([
            'title' => "STREET\nCULTURE",
            'subtitle' => 'NEW COLLECTION',
            'description' => 'Redefining urban fashion with premium cuts and bold designs. Up to 60% off on selected items.',
            'image_url' => 'https://images.unsplash.com/photo-1523396870179-16bed9562000?q=80&w=2000&auto=format&fit=crop',
            'cta_text' => 'SHOP THE DROP',
            'cta_url' => '/search',
            'secondary_cta_text' => 'VIEW COLLECTION',
            'secondary_cta_url' => '/search',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        HeroSlide::create([
            'title' => "WINTER\nESSENTIALS",
            'subtitle' => 'SEASONAL DROP',
            'description' => 'Stay warm while staying fresh. New winter collection featuring premium hoodies, jackets, and more.',
            'image_url' => 'https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?q=80&w=2000&auto=format&fit=crop',
            'cta_text' => 'EXPLORE NOW',
            'cta_url' => '/search?season=winter',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        HeroSlide::create([
            'title' => "EXCLUSIVE\nCOLLAB",
            'subtitle' => 'LIMITED EDITION',
            'description' => 'Limited edition collaboration. Only 100 pieces available worldwide. Don\'t miss out.',
            'image_url' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=2000&auto=format&fit=crop',
            'cta_text' => 'SHOP LIMITED DROP',
            'cta_url' => '/search?collection=collab',
            'secondary_cta_text' => 'LEARN MORE',
            'secondary_cta_url' => '/about',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // Create Promotional Banners
        Banner::create([
            'title' => 'Flash Sale - Up to 70% OFF',
            'description' => 'Limited time offer! Don\'t miss out on massive discounts.',
            'type' => 'hype',
            'position' => 'header-sticky',
            'image_url' => null,
            'cta_text' => 'Shop Now',
            'cta_url' => '/flash-sale',
            'background_color' => '#ff0000',
            'text_color' => '#ffffff',
            'is_active' => true,
            'sort_order' => 1,
            'impressions' => rand(1000, 5000),
            'clicks' => rand(50, 500),
        ]);

        Banner::create([
            'title' => 'New Arrivals Just Dropped',
            'description' => 'Check out the latest additions to our collection.',
            'type' => 'standard',
            'position' => 'mid-page',
            'image_url' => 'https://images.unsplash.com/photo-1558769132-cb1aea1f5049?q=80&w=1200&auto=format&fit=crop',
            'cta_text' => 'Discover New',
            'cta_url' => '/search?sort=newest',
            'is_active' => true,
            'sort_order' => 1,
            'impressions' => rand(500, 2000),
            'clicks' => rand(20, 200),
        ]);

        Banner::create([
            'title' => 'Join the Style91 Community',
            'description' => 'Get exclusive access to drops, events, and member-only perks.',
            'type' => 'community',
            'position' => 'mid-page',
            'image_url' => 'https://images.unsplash.com/photo-1529612700005-e35377bf1415?q=80&w=1200&auto=format&fit=crop',
            'cta_text' => 'Join Club',
            'cta_url' => '/club',
            'is_active' => true,
            'sort_order' => 2,
            'impressions' => rand(300, 1500),
            'clicks' => rand(10, 150),
        ]);

        // Create Drop Notification Banner
        Banner::create([
            'title' => 'EXCLUSIVE DROP ALERT',
            'description' => 'New limited edition collection drops in 48 hours. Set your reminder!',
            'type' => 'drop',
            'position' => 'hero',
            'image_url' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=2000&auto=format&fit=crop',
            'video_url' => null,
            'cta_text' => 'Notify Me',
            'cta_url' => '/drops/upcoming',
            'start_date' => now(),
            'end_date' => now()->addDays(3),
            'is_active' => true,
            'sort_order' => 1,
            'metadata' => json_encode([
                'countdown_date' => now()->addHours(48)->toIso8601String(),
                'stock_quantity' => 100,
                'hype_level' => 'high',
            ]),
        ]);

        $this->command->info('Banner seeder completed successfully!');
        $this->command->info('Created ' . HeroSlide::count() . ' hero slides');
        $this->command->info('Created ' . Banner::count() . ' banners');
    }
}
