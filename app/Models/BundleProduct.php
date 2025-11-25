<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BundleProduct extends Model
{
    protected $fillable = [
        'bundle_id',
        'product_id',
        'quantity',
    ];

    public function bundle()
    {
        return $this->belongsTo(ProductBundle::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
