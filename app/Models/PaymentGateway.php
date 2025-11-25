<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'config',
        'rules',
        'is_active',
        'is_test_mode',
        'display_order',
    ];

    protected $casts = [
        'config' => 'array',
        'rules' => 'array',
        'is_active' => 'boolean',
        'is_test_mode' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('display_order');
    }

    public function isAvailableForOrder($orderTotal, $userLocation = null)
    {
        if (!$this->is_active) {
            return false;
        }

        $rules = $this->rules ?? [];

        // Check minimum order value
        if (isset($rules['min_order_value']) && $orderTotal < $rules['min_order_value']) {
            return false;
        }

        // Check maximum order value
        if (isset($rules['max_order_value']) && $orderTotal > $rules['max_order_value']) {
            return false;
        }

        // Check COD availability by location
        if ($this->code === 'cod' && isset($rules['available_states']) && $userLocation) {
            if (!in_array($userLocation, $rules['available_states'])) {
                return false;
            }
        }

        return true;
    }

    public function getConfigValue($key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }
}
