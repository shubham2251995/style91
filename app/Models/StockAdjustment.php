<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    protected $fillable = [
        'product_id',
        'variant_id',
        'user_id',
        'quantity_change',
        'old_quantity',
        'new_quantity',
        'reason',
        'notes',
    ];

    protected $casts = [
        'quantity_change' => 'integer',
        'old_quantity' => 'integer',
        'new_quantity' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRecent($query)
    {
        return $query->latest()->limit(50);
    }

    public function getFormattedChangeAttribute()
    {
        return ($this->quantity_change > 0 ? '+' : '') . $this->quantity_change;
    }
}
