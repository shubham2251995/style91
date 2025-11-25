<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Branding
            ['group' => 'branding', 'key' => 'site_name', 'value' => 'Style91', 'type' => 'string'],
            ['group' => 'branding', 'key' => 'site_tagline', 'value' => 'Streetwear Revolution', 'type' => 'string'],
            ['group' => 'branding', 'key' => 'logo_url', 'value' => '', 'type' => 'url'],
            ['group' => 'branding', 'key' => 'favicon_url', 'value' => '', 'type' => 'url'],
            
            // Contact
            ['group' => 'contact', 'key' => 'contact_email', 'value' => 'contact@style91.com', 'type' => 'email'],
            ['group' => 'contact', 'key' => 'contact_phone', 'value' => '+1 (555) 123-4567', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'contact_address', 'value' => '123 Fashion Street, NYC, 10001', 'type' => 'string'],
            
            // Social
            ['group' => 'social', 'key' => 'facebook_url', 'value' => 'https://facebook.com/style91', 'type' => 'url'],
            ['group' => 'social', 'key' => 'instagram_url', 'value' => 'https://instagram.com/style91', 'type' => 'url'],
            ['group' => 'social', 'key' => 'twitter_url', 'value' => 'https://twitter.com/style91', 'type' => 'url'],
            ['group' => 'social', 'key' => 'youtube_url', 'value' => '', 'type' => 'url'],
            ['group' => 'social', 'key' => 'tiktok_url', 'value' => '', 'type' => 'url'],
            
            // SEO
            ['group' => 'seo', 'key' => 'meta_title', 'value' => 'Style91 | Premium Streetwear Fashion', 'type' => 'string'],
            ['group' => 'seo', 'key' => 'meta_description', 'value' => 'Discover exclusive streetwear drops, limited editions, and premium fashion at Style91. Your destination for authentic urban style.', 'type' => 'string'],
            ['group' => 'seo', 'key' => 'meta_keywords', 'value' => 'streetwear, fashion, style91, urban clothing, premium apparel, limited edition', 'type' => 'string'],
            ['group' => 'seo', 'key' => 'og_image', 'value' => '/images/og-default.jpg', 'type' => 'url'],
            
            // Content
            ['group' => 'content', 'key' => 'footer_text', 'value' => 'Built for the culture.', 'type' => 'string'],
            ['group' => 'content', 'key' => 'welcome_message', 'value' => 'Welcome to Style91', 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
