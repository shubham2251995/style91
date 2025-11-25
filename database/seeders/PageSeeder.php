<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'content' => '<h1>About Style91</h1><p>Welcome to Style91, the ultimate destination for premium streetwear.</p>',
                'meta_title' => 'About Us | Style91',
                'meta_description' => 'Learn more about Style91 and our mission.',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'content' => '<h1>Contact Us</h1><p>Email: support@style91.com</p>',
                'meta_title' => 'Contact Us | Style91',
                'meta_description' => 'Get in touch with the Style91 team.',
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms',
                'content' => '<h1>Terms of Service</h1><p>Please read these terms carefully.</p>',
                'meta_title' => 'Terms of Service | Style91',
                'meta_description' => 'Style91 Terms of Service.',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy',
                'content' => '<h1>Privacy Policy</h1><p>Your privacy is important to us.</p>',
                'meta_title' => 'Privacy Policy | Style91',
                'meta_description' => 'Style91 Privacy Policy.',
            ],
            [
                'title' => 'Returns & Exchanges',
                'slug' => 'returns',
                'content' => '<h1>Returns & Exchanges</h1><p>Easy returns within 30 days.</p>',
                'meta_title' => 'Returns | Style91',
                'meta_description' => 'Style91 Returns Policy.',
            ],
            [
                'title' => 'Shipping Information',
                'slug' => 'shipping',
                'content' => '<h1>Shipping Information</h1><p>We ship worldwide.</p>',
                'meta_title' => 'Shipping | Style91',
                'meta_description' => 'Style91 Shipping Information.',
            ],
            [
                'title' => 'Careers',
                'slug' => 'careers',
                'content' => '<h1>Careers</h1><p>Join the Style91 team.</p>',
                'meta_title' => 'Careers | Style91',
                'meta_description' => 'Careers at Style91.',
            ],
            [
                'title' => 'Track Your Order',
                'slug' => 'track-order',
                'content' => '<h1>Track Your Order</h1><p>Enter your order ID to track status.</p>',
                'meta_title' => 'Track Order | Style91',
                'meta_description' => 'Track your Style91 order.',
            ],
            [
                'title' => 'Gift Cards',
                'slug' => 'gift-cards',
                'content' => '<h1>Gift Cards</h1><p>Give the gift of style.</p>',
                'meta_title' => 'Gift Cards | Style91',
                'meta_description' => 'Buy Style91 Gift Cards.',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
