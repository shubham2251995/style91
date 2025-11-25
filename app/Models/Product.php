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
        'category', // Assuming we have categories or just a string
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
}
