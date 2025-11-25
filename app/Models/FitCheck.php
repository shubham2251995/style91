<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FitCheck extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'tagged_products' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getProductsAttribute()
    {
        if (!$this->tagged_products) return collect();
        return Product::whereIn('id', $this->tagged_products)->get();
    }
}
