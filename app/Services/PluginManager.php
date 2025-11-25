<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class PluginManager
{
    protected $plugins = [];

    public function __construct()
    {
        $this->loadPlugins();
    }

    public function loadPlugins()
    {
        // Define defaults
        $defaults = [
            'squad_mode' => ['group' => 'A', 'name' => 'Squad Mode'],
            'social_unlock' => ['group' => 'A', 'name' => 'Social Unlock'],
            'flex_cards' => ['group' => 'A', 'name' => 'Flex Cards'],
            'inner_circle' => ['group' => 'A', 'name' => 'The Inner Circle'],
            
            'raffles' => ['group' => 'B', 'name' => 'Raffles'],
            'mystery_boxes' => ['group' => 'B', 'name' => 'Mystery Boxes'],
            'crowd_drop' => ['group' => 'B', 'name' => 'Crowd-Drop'],
            'cart_reservation' => ['group' => 'B', 'name' => 'Cart Reservation'],
            'daily_drop' => ['group' => 'B', 'name' => 'Daily Drop'],

            'digital_wardrobe' => ['group' => 'C', 'name' => 'Digital Wardrobe'],
            'fit_check' => ['group' => 'C', 'name' => 'Fit Check'],
            'stealth_rewards' => ['group' => 'C', 'name' => 'Stealth Rewards'],
            'remix_studio' => ['group' => 'C', 'name' => 'Remix Studio'],

            'ai_stylist' => ['group' => 'D', 'name' => 'AI Stylist'],
            'sonic_mode' => ['group' => 'D', 'name' => 'Sonic Mode'],
            'drop_radar' => ['group' => 'D', 'name' => 'Drop Radar'],
            'the_vault' => ['group' => 'D', 'name' => 'The Vault'],
            'resell_market' => ['group' => 'D', 'name' => 'Resell Market'],

            'ghost_search' => ['group' => 'E', 'name' => 'Ghost Search'],
            'vibe_check' => ['group' => 'E', 'name' => 'Vibe Check'],
            'swipe_to_cop' => ['group' => 'E', 'name' => 'Swipe-to-Cop'],
            'smart_bundling' => ['group' => 'E', 'name' => 'Smart Bundling'],

            'session_logger' => ['group' => 'F', 'name' => 'Session Logger'],
            'heatmap_tracker' => ['group' => 'F', 'name' => 'Heatmap Tracker'],
            'god_view' => ['group' => 'F', 'name' => 'God View'],
            'journey_map' => ['group' => 'F', 'name' => 'Journey Map'],
            'funnel_doctor' => ['group' => 'F', 'name' => 'Funnel Doctor'],

            'profit_pilot' => ['group' => 'G', 'name' => 'Profit Pilot'],
            'stock_prophet' => ['group' => 'G', 'name' => 'Stock Prophet'],
            'dead_stock_reaper' => ['group' => 'G', 'name' => 'Dead Stock Reaper'],
            'channel_vision' => ['group' => 'G', 'name' => 'Channel Vision'],

            'config_engine' => ['group' => 'H', 'name' => 'Config Engine'],
            'the_oracle' => ['group' => 'H', 'name' => 'The Oracle'],

            'mission_control' => ['group' => 'I', 'name' => 'Mission Control UI'],
            'voice_command' => ['group' => 'I', 'name' => 'Voice Command'],
            'mobile_commander' => ['group' => 'I', 'name' => 'Mobile Commander'],
            'action_center' => ['group' => 'I', 'name' => 'Action Center'],

            'token_gate' => ['group' => 'J', 'name' => 'Token Gate'],
            'vote_to_make' => ['group' => 'J', 'name' => 'Vote-to-Make'],
            'treasury' => ['group' => 'J', 'name' => 'Treasury'],

            'streetwear_tv' => ['group' => 'K', 'name' => 'Streetwear TV'],
            'editorial' => ['group' => 'K', 'name' => 'Editorial'],
            'lookbook' => ['group' => 'K', 'name' => 'Lookbook'],

            'pod_api' => ['group' => 'L', 'name' => 'Print-on-Demand API'],
            'customizer' => ['group' => 'L', 'name' => 'Customizer'],

            'popup_pos' => ['group' => 'M', 'name' => 'Pop-Up POS'],
            'magic_mirror' => ['group' => 'M', 'name' => 'Magic Mirror'],

            'bulk_order_form' => ['group' => 'N', 'name' => 'Bulk Order Form'],
            'quote_engine' => ['group' => 'N', 'name' => 'Quote Engine'],
            'tiered_pricing' => ['group' => 'N', 'name' => 'Tiered Pricing'],
            'custom_branding' => ['group' => 'N', 'name' => 'Custom Branding'],
        ];

        // Gracefully handle missing tables during installation
        try {
            // Sync with DB
            foreach ($defaults as $key => $data) {
                if (!\Illuminate\Support\Facades\DB::table('plugins')->where('key', $key)->exists()) {
                    \Illuminate\Support\Facades\DB::table('plugins')->insert([
                        'key' => $key,
                        'group' => $data['group'],
                        'name' => $data['name'],
                        'active' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Load from DB
            $this->plugins = \Illuminate\Support\Facades\DB::table('plugins')
                ->get()
                ->keyBy('key')
                ->map(function ($item) {
                    return (array) $item;
                })
                ->toArray();
        } catch (\Exception $e) {
            // Table doesn't exist (pre-installation), use defaults with active=false
            $this->plugins = [];
            foreach ($defaults as $key => $data) {
                $this->plugins[$key] = array_merge($data, ['key' => $key, 'active' => false]);
            }
        }
    }

    public function isActive($key)
    {
        return $this->plugins[$key]['active'] ?? false;
    }

    public function activate($key)
    {
        \Illuminate\Support\Facades\DB::table('plugins')->where('key', $key)->update(['active' => true]);
        $this->plugins[$key]['active'] = true;
    }

    public function deactivate($key)
    {
        \Illuminate\Support\Facades\DB::table('plugins')->where('key', $key)->update(['active' => false]);
        $this->plugins[$key]['active'] = false;
    }

    public function getAll()
    {
        return $this->plugins;
    }
}
