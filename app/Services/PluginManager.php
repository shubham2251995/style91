<?php

namespace App\Services;

use App\Models\Plugin;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PluginManager
{
    protected $plugins = [];

    public function __construct()
    {
        $this->loadPlugins();
    }

    public function loadPlugins()
    {
        // Load plugin definitions from config
        $pluginDefinitions = config('plugins', []);
        
        // Define minimal defaults for backward compatibility
        $minimalDefaults = [
            'squad_mode' => ['group' => 'A', 'name' => 'Squad Mode'],
            'social_unlock' => ['group' => 'A', 'name' => 'Social Unlock'],
            'flex_cards' => ['group' => 'A', 'name' => 'Flex Cards'],
            'inner_circle' => ['group' => 'A', 'name' => 'The Inner Circle'],
            // ... keeping all existing plugins for compatibility
        ];
        
        // Merge config definitions with minimal defaults
        $defaults = array_merge($minimalDefaults, $pluginDefinitions);

        // Gracefully handle missing tables during installation
        try {
            // Sync with DB
            foreach ($defaults as $key => $data) {
                Plugin::firstOrCreate(
                    ['key' => $key],
                    [
                        'group' => $data['group'] ?? 'Z',
                        'name' => $data['name'] ?? 'Unknown',
                        'description' => $data['description'] ?? null,
                        'features' => $data['features'] ?? null,
                        'locations' => $data['locations'] ?? null,
                        'icon' => $data['icon'] ?? null,
                        'active' => false
                    ]
                );
            }

            // Load from DB
            $this->plugins = Plugin::all()
                ->keyBy('key')
                ->map(function ($item) {
                    return $item->toArray();
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
        $plugin = Plugin::where('key', $key)->first();
        if ($plugin) {
            $plugin->update(['active' => true]);
            $this->plugins[$key]['active'] = true;
        }
    }

    public function deactivate($key)
    {
        $plugin = Plugin::where('key', $key)->first();
        if ($plugin) {
            $plugin->update(['active' => false]);
            $this->plugins[$key]['active'] = false;
        }
    }

    public function getAll()
    {
        return $this->plugins;
    }

    public function getPlugin($key)
    {
        return $this->plugins[$key] ?? null;
    }

    public function updateConfig($key, array $config)
    {
        $plugin = Plugin::where('key', $key)->first();
        if ($plugin) {
            $plugin->update(['config' => $config]);
            $this->plugins[$key]['config'] = $config;
            return true;
        }
        return false;
    }
}
