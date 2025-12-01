<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    use HasFactory;

    protected $table = 'sections';

    protected $fillable = [
        'type',
        'title',
        'subtitle',
        'content',
        'image_url',
        'link_url',
        'link_text',
        'order',
        'is_active',
        'visibility_rules',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'visibility_rules' => 'array',
        'settings' => 'array',
        'content' => 'array',
        'order' => 'integer',
    ];

    /**
     * Scope for active sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered sections
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Check if section is visible for specific user and device
     */
    public function isVisibleFor($user = null, $device = 'desktop')
    {
        if (!$this->is_active) {
            return false;
        }

        $rules = $this->visibility_rules ?? [];

        // Check device visibility
        if (isset($rules['devices']) && !in_array($device, $rules['devices'])) {
            return false;
        }

        // Check authentication requirement
        if (isset($rules['auth_required']) && $rules['auth_required'] && !$user) {
            return false;
        }

        // Check if guest only
        if (isset($rules['guest_only']) && $rules['guest_only'] && $user) {
            return false;
        }

        return true;
    }

    /**
     * Get products for this section (if applicable)
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'homepage_section_products')
            ->orderBy('homepage_section_products.order');
    }
}
