<?php

namespace App\Services;

use App\Models\Coupon;
use Illuminate\Support\Facades\Log;

class CouponService
{
    public function validate($code, $cartTotal)
    {
        $coupon = Coupon::where('code', $code)
                        ->where('is_active', true)
                        ->where('expires_at', '>=', now())
                        ->first();

        if (!$coupon) {
            return [
                'valid' => false,
                'message' => 'Invalid or expired coupon code'
            ];
        }

        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return [
                'valid' => false,
                'message' => 'Coupon usage limit reached'
            ];
        }

        if ($coupon->min_order_value && $cartTotal < $coupon->min_order_value) {
            return [
                'valid' => false,
                'message' => 'Minimum order value of ₹' . $coupon->min_order_value . ' required'
            ];
        }

        return [
            'valid' => true,
            'coupon' => $coupon,
            'message' => 'Coupon applied successfully'
        ];
    }

    public function calculateDiscount(Coupon $coupon, $cartTotal)
    {
        if ($coupon->type === 'percentage') {
            return ($cartTotal * $coupon->value) / 100;
        }

        return min($coupon->value, $cartTotal);
    }

    public function apply(Coupon $coupon)
    {
        $coupon->increment('used_count');
    }
}
