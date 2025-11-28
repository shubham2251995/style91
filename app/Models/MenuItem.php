<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id', 
        'title', 
        'url', 
        'route', 
        'parameters', 
        'parent_id', 
        'order', 
        'target'
    ];

    protected $casts = [
        'parameters' => 'array',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }
    
    public function getLinkAttribute()
    {
        if ($this->route) {
            try {
                return route($this->route, $this->parameters ?? []);
            } catch (\Exception $e) {
                return '#';
            }
        }
        return $this->url ?? '#';
    }
}
