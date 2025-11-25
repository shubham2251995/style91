<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecentlyViewed extends Model
{
    public $timestamps = false;
    
    protected $table = 'recently_viewed';
    
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function track($productId, $userId = null, $sessionId = null)
    {
        // Delete old entry if exists
        self::where('product_id', $productId)
            ->where(function($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->delete();

        // Create new entry
        self::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'product_id' => $productId,
            'viewed_at' => now(),
        ]);

        // Keep only last 20 viewed products
        self::where(function($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->orderBy('viewed_at', 'desc')
            ->skip(20)
            ->take(PHP_INT_MAX)
            ->delete();
    }
}
