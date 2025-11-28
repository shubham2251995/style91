<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'slug', 'location'];

    public function items()
    {
        return $this->hasMany(MenuItem::class)->orderBy('order');
    }
    
    // Helper to get items as a tree
    public function tree()
    {
        return $this->items()->whereNull('parent_id')->with('children')->get();
    }
}
