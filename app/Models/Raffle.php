<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Raffle extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'closes_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function entries()
    {
        return $this->hasMany(RaffleEntry::class);
    }

    public function getCurrentEntriesCount()
    {
        return $this->entries()->count();
    }
}
