<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MysteryBoxItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function box()
    {
        return $this->belongsTo(MysteryBox::class, 'mystery_box_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
