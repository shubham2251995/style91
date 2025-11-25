<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAlert extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'notified_at',
    ];

    protected $casts = [
        'notified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function subscribe($userId, $productId)
    {
        return static::firstOrCreate([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);
    }

    public static function isSubscribed($userId, $productId)
    {
        return static::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }

    public function markAsNotified()
    {
        $this->update(['notified_at' => now()]);
    }
}
