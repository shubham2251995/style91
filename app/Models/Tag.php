<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'color',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    /**
     * Products with this tag
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Get product count
     */
    public function getProductCountAttribute()
    {
        return $this->products()->count();
    }
}
