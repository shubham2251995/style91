<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PriceTier extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function getDiscountForQuantity($productId, $quantity)
    {
        return static::where(function ($query) use ($productId) {
                $query->where('product_id', $productId)
                      ->orWhereNull('product_id'); // Global tiers
            })
            ->where('min_quantity', '<=', $quantity)
            ->orderByDesc('min_quantity')
            ->first()
            ?->discount_percentage ?? 0;
    }
}
