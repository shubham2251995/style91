<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    protected $fillable = [
        'key',
        'group',
        'name',
        'active',
        'config'
    ];

    protected $casts = [
        'active' => 'boolean',
        'config' => 'array'
    ];

    /**
     * Scope a query to only include active plugins.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
