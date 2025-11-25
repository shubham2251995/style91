<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'size',
        'color',
        'stock_quantity',
        'price_modifier',
        'image_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getFinalPrice()
    {
        return $this->product->price + $this->price_modifier;
    }

    public function getDisplayName()
    {
        $parts = [];
        if ($this->size) $parts[] = $this->size;
        if ($this->color) $parts[] = $this->color;
        return implode(' - ', $parts);
    }
}
