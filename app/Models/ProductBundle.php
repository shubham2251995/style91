<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBundle extends Model
{
    protected $fillable = [
        'name',
        'description',
        'slug',
        'image_url',
        'price',
        'compare_price',
        'discount_percentage',
        'is_active',
        'stock_quantity',
    ];

    public function bundleProducts()
    {
        return $this->hasMany(BundleProduct::class);
    }
}
