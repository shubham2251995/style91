<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = [
        'type',
        'title',
        'content',
        'order',
        'is_active',
        'rules',
    ];

    protected $casts = [
        'content' => 'array',
        'rules' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope to get only active sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get sections ordered by their order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Check if section should be visible based on rules
     */
    public function isVisibleFor($user = null, $device = 'desktop')
    {
        if (!$this->is_active) {
            return false;
        }

        if (!$this->rules) {
            return true;
        }

        // Check device compatibility
        if (isset($this->rules['devices']) && !in_array($device, $this->rules['devices'])) {
            return false;
        }

        // Check authentication requirements
        if (isset($this->rules['auth_required']) && $this->rules['auth_required'] && !$user) {
            return false;
        }

        if (isset($this->rules['guest_only']) && $this->rules['guest_only'] && $user) {
            return false;
        }

        // Check date range
        $now = now();
        if (isset($this->rules['date_start']) && $now->lt($this->rules['date_start'])) {
            return false;
        }

        if (isset($this->rules['date_end']) && $now->gt($this->rules['date_end'])) {
            return false;
        }

        return true;
    }
}
