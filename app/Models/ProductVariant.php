<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'compare_price',
        'stock_quantity',
        'image_url',
        'size',
        'color',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function getOptionLabel()
    {
        $labels = [];
        if ($this->size) {
            $labels[] = 'Size: ' . $this->size;
        }
        if ($this->color) {
            $labels[] = 'Color: ' . $this->color;
        }
        return implode(', ', $labels);
    }

    public function getFinalPrice()
    {
        return $this->price ?? $this->product->price;
    }
}
