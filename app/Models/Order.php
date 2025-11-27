<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'guest_email',
        'status',
        'total',
        'total_amount',
        'discount_amount',
        'coupon_code',
        'influencer_id',
        'shipping_address',
        'shipping_phone',
        'shipping_cost',
        'shipping_method',
        'payment_method',
        'payment_status',
        'payment_id',
        'tracking_number',
        'shipped_at',
        'delivered_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function returnRequests()
    {
        return $this->hasMany(ReturnRequest::class);
    }

    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function isEligibleForReturn()
    {
        // Order must be delivered
        if ($this->status !== 'delivered') {
            return false;
        }

        // Must be within 30 days of delivery
        $deliveryDate = $this->delivered_at ?? $this->updated_at;
        $daysSinceDelivery = now()->diffInDays($deliveryDate);

        return $daysSinceDelivery <= 30;
    }
}
