<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Video;
use Illuminate\Support\Str;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        Video::create([
            'title' => 'SEASON 01: GENESIS',
            'slug' => 'season-01-genesis',
            'description' => 'The beginning of everything. Behind the scenes of our first drop.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // Placeholder
            'thumbnail_url' => 'https://images.unsplash.com/photo-1531297461136-82lw9z1w1w1w?auto=format&fit=crop&w=800&q=80',
            'duration' => '04:20',
            'is_featured' => true,
            'category' => 'behind_the_scenes',
            'views' => 12500,
        ]);

        Video::create([
            'title' => 'STREETWEAR IS DEAD',
            'slug' => 'streetwear-is-dead',
            'description' => 'A manifesto on the current state of fashion and where we are going.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'thumbnail_url' => 'https://images.unsplash.com/photo-1523398002811-999ca8dec234?auto=format&fit=crop&w=800&q=80',
            'duration' => '12:00',
            'is_featured' => false,
            'category' => 'interview',
            'views' => 8900,
        ]);

        Video::create([
            'title' => 'LOOKBOOK: NEON NIGHTS',
            'slug' => 'lookbook-neon-nights',
            'description' => 'Visual vibes from Tokyo.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'thumbnail_url' => 'https://images.unsplash.com/photo-1552374196-c4e7ffc6e126?auto=format&fit=crop&w=800&q=80',
            'duration' => '02:45',
            'is_featured' => false,
            'category' => 'lookbook',
            'views' => 4500,
        ]);
    }
}
