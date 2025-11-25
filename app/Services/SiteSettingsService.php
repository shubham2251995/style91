<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SiteSettingsService
{
    /**
     * Get a setting value by key with caching
     */
    public function get($key, $default = null)
    {
        try {
            return SiteSetting::get($key, $default);
        } catch (\Exception $e) {
            Log::error("Error getting setting {$key}: " . $e->getMessage());
            return $default;
        }
    }

    /**
     * Set a setting value
     */
    public function set($key, $value, $group = 'general', $type = 'string')
    {
        try {
            return SiteSetting::set($key, $value, $group, $type);
        } catch (\Exception $e) {
            Log::error("Error setting {$key}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all settings for a group
     */
    public function getGroup($group)
    {
        try {
            return SiteSetting::all($group);
        } catch (\Exception $e) {
            Log::error("Error getting settings for group {$group}: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all settings
     */
    public function all()
    {
        try {
            return SiteSetting::all();
        } catch (\Exception $e) {
            Log::error("Error getting all settings: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Clear cache
     */
    public function clearCache()
    {
        SiteSetting::clearCache();
    }
}
