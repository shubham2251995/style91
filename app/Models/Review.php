<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'review_text',
        'images',
        'is_verified',
        'is_approved',
        'helpful_count',
        'not_helpful_count',
    ];

    protected $casts = [
        'images' => 'array',
        'is_verified' => 'boolean',
        'is_approved' => 'boolean',
        'rating' => 'integer',
        'helpful_count' => 'integer',
        'not_helpful_count' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Get average rating for a product
     */
    public static function getAverageRating($productId)
    {
        return static::where('product_id', $productId)
            ->where('is_approved', true)
            ->avg('rating') ?? 0;
    }

    /**
     * Get review count for a product
     */
    public static function getReviewCount($productId)
    {
        return static::where('product_id', $productId)
            ->where('is_approved', true)
            ->count();
    }
}
