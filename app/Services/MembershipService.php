<?php

namespace App\Services;

use App\Models\User;
use App\Models\MembershipTier;

class MembershipService
{
    /**
     * Check if user qualifies for a tier upgrade based on lifetime spend.
     */
    public function checkUpgrade(User $user)
    {
        try {
            // Find the highest tier the user qualifies for
            $targetTier = MembershipTier::where('threshold', '<=', $user->lifetime_spend)
                ->orderBy('threshold', 'desc')
                ->first();

            if ($targetTier && $targetTier->id !== $user->membership_tier_id) {
                $user->update(['membership_tier_id' => $targetTier->id]);
                return $targetTier;
            }

            return null;
        } catch (\Exception $e) {
            // Table doesn't exist (pre-installation)
            return null;
        }
    }

    /**
     * Calculate discount amount for a given subtotal.
     */
    public function calculateDiscount(User $user, $amount)
    {
        try {
            if (!$user->membership_tier_id) {
                return 0;
            }

            $tier = MembershipTier::find($user->membership_tier_id);
            if (!$tier) {
                return 0;
            }

            return ($amount * $tier->discount_percentage) / 100;
        } catch (\Exception $e) {
            // Table doesn't exist (pre-installation)
            return 0;
        }
    }

    /**
     * Get progress to next tier.
     */
    public function getNextTierProgress(User $user)
    {
        try {
            $currentSpend = $user->lifetime_spend;
            
            $nextTier = MembershipTier::where('threshold', '>', $currentSpend)
                ->orderBy('threshold', 'asc')
                ->first();

            if (!$nextTier) {
                return [
                    'next_tier' => null,
                    'amount_needed' => 0,
                    'percentage' => 100
                ];
            }

            $amountNeeded = $nextTier->threshold - $currentSpend;
            // Simple percentage calculation (0 to threshold)
            // Or relative to current tier? Let's do absolute for simplicity first.
            $percentage = ($currentSpend / $nextTier->threshold) * 100;

            return [
                'next_tier' => $nextTier,
                'amount_needed' => $amountNeeded,
                'percentage' => min($percentage, 100)
            ];
        } catch (\Exception $e) {
            // Table doesn't exist (pre-installation)
            return [
                'next_tier' => null,
                'amount_needed' => 0,
                'percentage' => 0
            ];
        }
    }
}
