<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        Article::create([
            'title' => 'THE FUTURE OF HYPE',
            'slug' => 'the-future-of-hype',
            'excerpt' => 'Why the traditional drop model is dead and what comes next.',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'image_url' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&w=800&q=80',
            'author_id' => $user->id,
            'category' => 'editorial',
            'is_featured' => true,
            'published_at' => now(),
            'tags' => ['culture', 'future', 'tech'],
        ]);

        Article::create([
            'title' => 'DROP 002: NEON GENESIS',
            'slug' => 'drop-002-neon-genesis',
            'excerpt' => 'Everything you need to know about our upcoming collection.',
            'content' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'image_url' => 'https://images.unsplash.com/photo-1500917293891-ef795e70e1f6?auto=format&fit=crop&w=800&q=80',
            'author_id' => $user->id,
            'category' => 'drop',
            'is_featured' => false,
            'published_at' => now()->subDays(2),
            'tags' => ['drop', 'collection', 'news'],
        ]);

        Article::create([
            'title' => 'INTERVIEW: DESIGNER X',
            'slug' => 'interview-designer-x',
            'excerpt' => 'A conversation with the mind behind the madness.',
            'content' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
            'image_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=800&q=80',
            'author_id' => $user->id,
            'category' => 'interview',
            'is_featured' => false,
            'published_at' => now()->subDays(5),
            'tags' => ['interview', 'design', 'art'],
        ]);
    }
}
