<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BannerAnalytic extends Model
{
    protected $fillable = [
        'banner_id', 'date',
        'impressions', 'clicks', 'shares',
        'video_plays', 'avg_watch_time', 'drop_notifications',
    ];

    protected $casts = [
        'date' => 'date',
        'impressions' => 'integer',
        'clicks' => 'integer',
        'shares' => 'integer',
        'video_plays' => 'integer',
        'avg_watch_time' => 'integer',
        'drop_notifications' => 'integer',
    ];

    /**
     * Relationships
     */
    public function banner(): BelongsTo
    {
        return $this->belongsTo(Banner::class);
    }

    /**
     * Accessors
     */
    public function getCtrAttribute(): float
    {
        if ($this->impressions === 0) {
            return 0;
        }

        return ($this->clicks / $this->impressions) * 100;
    }

    public function getEngagementRateAttribute(): float
    {
        if ($this->impressions === 0) {
            return 0;
        }

        $engagements = $this->clicks + $this->shares + $this->drop_notifications;
        return ($engagements / $this->impressions) * 100;
    }
}
