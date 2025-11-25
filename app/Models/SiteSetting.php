<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
    ];

    protected $casts = [
        'value' => 'string',
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        try {
            return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
                $setting = self::where('key', $key)->first();
                return $setting ? $setting->value : $default;
            });
        } catch (\Exception $e) {
            // Table might not exist yet (before migration)
            return $default;
        }
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $group = 'general', $type = 'string')
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
            ]
        );

        // Clear cache
        Cache::forget("setting_{$key}");
        Cache::forget('all_settings');

        return $setting;
    }

    /**
     * Get all settings as key-value array
     */
    public static function all($group = null)
    {
        try {
            $cacheKey = $group ? "settings_{$group}" : 'all_settings';

            return Cache::remember($cacheKey, 3600, function () use ($group) {
                $query = self::query();
                
                if ($group) {
                    $query->where('group', $group);
                }

                return $query->get()->pluck('value', 'key')->toArray();
            });
        } catch (\Exception $e) {
            // Table might not exist yet (before migration)
            return [];
        }
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        Cache::flush();
    }
}
