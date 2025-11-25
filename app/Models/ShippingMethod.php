<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'cost',
        'min_order_amount',
        'estimated_days_min',
        'estimated_days_max',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'estimated_days_min' => 'integer',
        'estimated_days_max' => 'integer',
        'display_order' => 'integer',
    ];

    public function zones()
    {
        return $this->belongsToMany(ShippingZone::class, 'shipping_zone_methods')
                    ->withPivot('cost_override', 'is_enabled')
                    ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('display_order');
    }

    public function getEstimatedDelivery()
    {
        return $this->estimated_days_min . '-' . $this->estimated_days_max . ' days';
    }
}
