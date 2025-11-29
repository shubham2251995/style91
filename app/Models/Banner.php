<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class Banner extends Model
{
    protected $fillable = [
        'type', 'title', 'subtitle', 'description',
        'media_type', 'desktop_media_url', 'mobile_media_url', 'media_thumbnail',
        'video_autoplay', 'video_loop', 'video_muted',
        'drop_date', 'stock_count', 'notify_enabled',
        'instagram_hashtag', 'tiktok_hashtag', 'social_feed_enabled',
        'ar_enabled', 'model_3d_url',
        'show_view_count', 'show_purchase_ticker', 'show_stock_ticker',
        'text_position', 'overlay_type', 'overlay_opacity',
        'background_color', 'text_color', 'accent_color',
        'entrance_animation', 'scroll_effect',
        'cta_text', 'cta_url', 'cta_style',
        'badge_text', 'badge_style',
        'position', 'display_priority',
        'is_active', 'start_date', 'end_date', 'visibility_rules',
    ];

    protected $casts = [
        'video_autoplay' => 'boolean',
        'video_loop' => 'boolean',
        'video_muted' => 'boolean',
        'notify_enabled' => 'boolean',
        'social_feed_enabled' => 'boolean',
        'ar_enabled' => 'boolean',
        'show_view_count' => 'boolean',
        'show_purchase_ticker' => 'boolean',
        'show_stock_ticker' => 'boolean',
        'overlay_opacity' => 'integer',
        'display_priority' => 'integer',
        'stock_count' => 'integer',
        'is_active' => 'boolean',
        'drop_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'visibility_rules' => 'array',
    ];

    /**
     * Relationships
     */
    public function heroSlides(): HasMany
    {
        return $this->hasMany(HeroSlide::class)->orderBy('slide_order');
    }

    public function dropNotifications(): HasMany
    {
        return $this->hasMany(DropNotification::class);
    }

    public function analytics(): HasMany
    {
        return $this->hasMany(BannerAnalytic::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            });
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopePosition($query, $position)
    {
        return $query->where('position', $position);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_priority', 'desc')->orderBy('created_at', 'desc');
    }

    /**
     * Accessors & Mutators
     */
    public function getIsDropActiveAttribute(): bool
    {
        if ($this->type !== 'drop' || !$this->drop_date) {
            return false;
        }

        return $this->drop_date->isFuture();
    }

    public function getTimeUntilDropAttribute(): ?array
    {
        if (!$this->is_drop_active) {
            return null;
        }

        $diff = now()->diff($this->drop_date);

        return [
            'days' => $diff->days,
            'hours' => $diff->h,
            'minutes' => $diff->i,
            'seconds' => $diff->s,
            'total_seconds' => $this->drop_date->diffInSeconds(now()),
        ];
    }

    public function getNotificationCountAttribute(): int
    {
        return $this->dropNotifications()->count();
    }

    /**
     * Methods
     */
    public function isCurrentlyVisible(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        // Check date range
        if ($this->start_date && $this->start_date->isFuture()) {
            return false;
        }

        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }

        return true;
    }

    public function incrementImpressions(): void
    {
        $today = now()->toDateString();
        $analytic = $this->analytics()->firstOrCreate(
            ['date' => $today],
            ['impressions' => 0]
        );
        $analytic->increment('impressions');
    }

    public function incrementClicks(): void
    {
        $today = now()->toDateString();
        $analytic = $this->analytics()->firstOrCreate(
            ['date' => $today],
            ['clicks' => 0]
        );
        $analytic->increment('clicks');
    }

    public function trackVideoPlay(int $watchTime = 0): void
    {
        $today = now()->toDateString();
        $analytic = $this->analytics()->firstOrCreate(
            ['date' => $today],
            ['video_plays' => 0, 'avg_watch_time' => 0]
        );
        
        $analytic->increment('video_plays');
        
        // Update average watch time
        if ($watchTime > 0) {
            $totalWatchTime = ($analytic->avg_watch_time * ($analytic->video_plays - 1)) + $watchTime;
            $analytic->avg_watch_time = $totalWatchTime / $analytic->video_plays;
            $analytic->save();
        }
    }
}
