<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = [
        'name',
        'countries',
        'states',
        'postcodes',
        'is_active',
    ];

    protected $casts = [
        'countries' => 'array',
        'states' => 'array',
        'postcodes' => 'array',
        'is_active' => 'boolean',
    ];

    public function shippingMethods()
    {
        return $this->belongsToMany(ShippingMethod::class, 'shipping_zone_methods')
                    ->withPivot('cost_override', 'is_enabled')
                    ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function matchesAddress($country, $state = null, $postcode = null)
    {
        // Check country
        if ($this->countries && !in_array($country, $this->countries)) {
            return false;
        }

        // Check state if provided
        if ($state && $this->states && !in_array($state, $this->states)) {
            return false;
        }

        // Check postcode if provided
        if ($postcode && $this->postcodes && !in_array($postcode, $this->postcodes)) {
            return false;
        }

        return true;
    }
}
