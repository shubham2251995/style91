<?php

if (!function_exists('plugin_active')) {
    /**
     * Check if a plugin is active
     *
     * @param string $key Plugin key
     * @return bool
     */
    function plugin_active($key)
    {
        try {
            return app(\App\Services\PluginManager::class)->isActive($key);
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('plugin_config')) {
    /**
     * Get plugin configuration
     *
     * @param string $key Plugin key
     * @param string|null $setting Specific setting to retrieve
     * @param mixed $default Default value if not found
     * @return mixed
     */
    function plugin_config($key, $setting = null, $default = null)
    {
        try {
            $manager = app(\App\Services\PluginManager::class);
            $plugin = $manager->getAll()[$key] ?? null;
            
            if (!$plugin) {
                return $default;
            }
            
            if ($setting) {
                return $plugin['config'][$setting] ?? $default;
            }
            
            return $plugin['config'] ?? [];
        } catch (\Exception $e) {
            return $default;
        }
    }
}
