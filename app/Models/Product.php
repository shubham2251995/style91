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

    public function availableSizes()
    {
        return $this->variants()->where('is_active', true)->distinct()->pluck('size')->filter();
    }

    public function availableColors()
    {
        return $this->variants()->where('is_active', true)->distinct()->pluck('color')->filter();
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
}
