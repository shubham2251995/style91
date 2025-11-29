<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image_url',
        'stock_quantity',
        'category_id',
        'category', // Keep for backward compatibility during migration
        'gender',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // SEO Methods
    public function getSeoTitle()
    {
        return $this->name . ' | Style91';
    }

    public function getSeoDescription()
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->description), 160);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function hasVariants()
    {
        return $this->variants()->exists();
    }

    public function variantOptions()
    {
        return $this->hasMany(VariantOption::class)->orderBy('display_order');
    }

    public function availableSizes()
    {
        // Get sizes from active variants
        return $this->variants()
            ->where('is_active', true)
            ->get()
            ->pluck('options.size')
            ->filter()
            ->unique()
            ->values();
    }

    public function availableColors()
    {
        // Get colors from active variants
        return $this->variants()
            ->where('is_active', true)
            ->get()
            ->pluck('options.color')
            ->filter()
            ->unique()
            ->values();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function hasTag($tagName)
    {
        return $this->tags()->where('name', $tagName)->exists();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->approved()->avg('rating') ?? 0;
    }

    public function reviewsCount()
    {
        return $this->reviews()->approved()->count();
    }

    public function flashSales()
    {
        return $this->belongsToMany(FlashSale::class, 'flash_sale_product')
            ->withPivot('discount_percentage', 'fixed_price')
            ->where('end_time', '>', now())
            ->where('start_time', '<=', now());
    }

    public function getActiveFlashSaleAttribute()
    {
        try {
            return $this->flashSales()->first();
        } catch (\Exception $e) {
            // Return null if table doesn't exist (migration not run yet)
            \Log::warning('Flash sale table missing or error accessing flash sales', [
                'product_id' => $this->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
