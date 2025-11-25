<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LookbookItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lookbook()
    {
        return $this->belongsTo(Lookbook::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
