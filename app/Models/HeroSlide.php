<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeroSlide extends Model
{
    protected $fillable = [
        'banner_id', 'title', 'subtitle', 'description',
        'media_type', 'desktop_media_url', 'mobile_media_url', 'thumbnail_url',
        'video_autoplay', 'video_duration',
        'text_alignment', 'text_color', 'overlay_opacity', 'custom_css',
        'cta_text', 'cta_url',
        'slide_order', 'is_active',
    ];

    protected $casts = [
        'video_autoplay' => 'boolean',
        'video_duration' => 'integer',
        'overlay_opacity' => 'integer',
        'slide_order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function banner(): BelongsTo
    {
        return $this->belongsTo(Banner::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('slide_order');
    }
}
