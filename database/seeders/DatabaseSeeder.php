<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database for production deployment.
     */
    public function run(): void
    {
        // 1. Seed Plugins (all inactive by default)
        $this->seedPlugins();
        
        // 2. Seed Membership Tiers
        $this->seedMembershipTiers();
        
        // 3. Seed Payment Gateways
        $this->seedPaymentGateways();
        
        // 4. Seed System Configurations
        $this->seedSystemConfigurations();
        
        // 5. Seed SEO Settings
        $this->seedSeoSettings();
        
        // 6. Seed Pages
        $this->call(PageSeeder::class);

        // 7. Seed Categories (NEW)
        $this->call(CategorySeeder::class);

        // 8. Seed Sample Products (good quality data suitable for production)
        $this->call(ProductSeeder::class);
        
        // 9. Seed Price Tiers
        $this->call(PriceTierSeeder::class);
        
        // 10. Seed Homepage Sections
        $this->call(HomepageSectionSeeder::class);
        
        // 11. Seed Site Settings
        $this->call(SiteSettingsSeeder::class);

        // 12. Seed Users (NEW)
        $this->call(UserSeeder::class);

        // 13. Seed Orders (NEW)
        $this->call(OrderSeeder::class);

        // 14. Seed Reviews (NEW)
        $this->call(ReviewSeeder::class);

        // 15. Seed Coupons (NEW)
        $this->call(CouponSeeder::class);
    }
    
    protected function seedPlugins()
    {
        $plugins = [
            // Group A: Social & Engagement
            ['key' => 'squad_mode', 'group' => 'A', 'name' => 'Squad Mode', 'active' => false],
            ['key' => 'social_unlock', 'group' => 'A', 'name' => 'Social Unlock', 'active' => false],
            ['key' => 'flex_cards', 'group' => 'A', 'name' => 'Flex Cards', 'active' => false],
            ['key' => 'inner_circle', 'group' => 'A', 'name' => 'The Inner Circle', 'active' => false],
            
            // Group B: Drops & Scarcity
            ['key' => 'raffles', 'group' => 'B', 'name' => 'Raffles', 'active' => false],
            ['key' => 'mystery_boxes', 'group' => 'B', 'name' => 'Mystery Boxes', 'active' => false],
            ['key' => 'crowd_drop', 'group' => 'B', 'name' => 'Crowd-Drop', 'active' => false],
            ['key' => 'cart_reservation', 'group' => 'B', 'name' => 'Cart Reservation', 'active' => false],
            ['key' => 'daily_drop', 'group' => 'B', 'name' => 'Daily Drop', 'active' => false],
            
            // Group C: Engagement & Community
            ['key' => 'digital_wardrobe', 'group' => 'C', 'name' => 'Digital Wardrobe', 'active' => false],
            ['key' => 'fit_check', 'group' => 'C', 'name' => 'Fit Check', 'active' => false],
            ['key' => 'stealth_rewards', 'group' => 'C', 'name' => 'Stealth Rewards', 'active' => false],
            ['key' => 'remix_studio', 'group' => 'C', 'name' => 'Remix Studio', 'active' => false],
        ];
        
        foreach ($plugins as $plugin) {
            DB::table('plugins')->updateOrInsert(
                ['key' => $plugin['key']],
                array_merge($plugin, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
    
    protected function seedMembershipTiers()
    {
        $tiers = [
            ['name' => 'Bronze', 'threshold' => 0, 'discount_percentage' => 0],
            ['name' => 'Silver', 'threshold' => 5000, 'discount_percentage' => 5],
            ['name' => 'Gold', 'threshold' => 15000, 'discount_percentage' => 10],
            ['name' => 'Platinum', 'threshold' => 30000, 'discount_percentage' => 15],
        ];
        
        foreach ($tiers as $tier) {
            DB::table('membership_tiers')->updateOrInsert(
                ['name' => $tier['name']],
                array_merge($tier, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
    
    protected function seedPaymentGateways()
    {
        $gateways = [
            [
                'name' => 'Cash on Delivery',
                'slug' => 'cod',
                'credentials' => json_encode([]),
                'is_active' => true
            ],
            [
                'name' => 'Razorpay',
                'slug' => 'razorpay',
                'credentials' => json_encode(['key' => '', 'secret' => '']),
                'is_active' => false
            ],
            [
                'name' => 'Cashfree',
                'slug' => 'cashfree',
                'credentials' => json_encode(['app_id' => '', 'secret_key' => '']),
                'is_active' => false
            ],
        ];
        
        foreach ($gateways as $gateway) {
            DB::table('payment_gateways')->updateOrInsert(
                ['slug' => $gateway['slug']],
                array_merge($gateway, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
    
    protected function seedSystemConfigurations()
    {
        $configs = [
            // SMS Settings
            ['key' => 'msg91_auth_key', 'value' => '', 'group' => 'sms'],
            ['key' => 'msg91_sender_id', 'value' => '', 'group' => 'sms'],
            ['key' => 'msg91_otp_template', 'value' => '', 'group' => 'sms'],
            
            // Email Settings
            ['key' => 'smtp_host', 'value' => '', 'group' => 'email'],
            ['key' => 'smtp_port', 'value' => '587', 'group' => 'email'],
            ['key' => 'smtp_username', 'value' => '', 'group' => 'email'],
            ['key' => 'smtp_password', 'value' => '', 'group' => 'email'],
            ['key' => 'mail_from_address', 'value' => 'noreply@style91.com', 'group' => 'email'],
            ['key' => 'mail_from_name', 'value' => 'Style91', 'group' => 'email'],
        ];
        
        foreach ($configs as $config) {
            DB::table('system_configurations')->updateOrInsert(
                ['key' => $config['key']],
                array_merge($config, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
    
    protected function seedSeoSettings()
    {
        $seoSettings = [
            ['key' => 'global_title', 'value' => 'Style91 | Premium Streetwear Fashion'],
            ['key' => 'global_description', 'value' => 'Discover exclusive streetwear drops, limited editions, and premium fashion at Style91. Your destination for authentic urban style.'],
            ['key' => 'global_keywords', 'value' => 'streetwear, fashion, style91, urban clothing, premium apparel, limited edition'],
            ['key' => 'og_image', 'value' => '/images/og-default.jpg'],
        ];
        
        foreach ($seoSettings as $setting) {
            DB::table('seo_settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
