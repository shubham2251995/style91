<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistAlert extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'alert_type',
        'threshold_price',
        'is_sent',
        'sent_at',
    ];

    protected $casts = [
        'threshold_price' => 'decimal:2',
        'is_sent' => 'boolean',
        'sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopePending($query)
    {
        return $query->where('is_sent', false);
    }

    public function scopePriceDropAlerts($query)
    {
        return $query->where('alert_type', 'price_drop');
    }

    public function scopeStockAlerts($query)
    {
        return $query->where('alert_type', 'back_in_stock');
    }

    public function markAsSent()
    {
        $this->update([
            'is_sent' => true,
            'sent_at' => now(),
        ]);
    }
}
