<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'minimum_order',
        'usage_limit',
        'used_count',
        'expires_at',
        'is_active',
        'is_public',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function isValid($orderTotal = 0)
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        if ($this->minimum_order && $orderTotal < $this->minimum_order) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($orderTotal)
    {
        if ($this->type === 'percentage') {
            return ($orderTotal * $this->value) / 100;
        }

        return min($this->value, $orderTotal); // Fixed amount, but not more than order total
    }

    public function incrementUsage()
    {
        $this->increment('used_count');
    }
}
