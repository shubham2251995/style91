<?php

namespace App\Livewire\Membership;

use Livewire\Component;
use App\Services\MembershipService;
use Illuminate\Support\Facades\Auth;
use App\Models\MembershipTier;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        $service = new MembershipService();
        
        // Ensure we have tiers to show
        $tiers = MembershipTier::orderBy('threshold', 'asc')->get();
        $currentTier = $user->membershipTier;
        $progress = $service->getNextTierProgress($user);

        return view('livewire.membership.dashboard', [
            'user' => $user,
            'tiers' => $tiers,
            'currentTier' => $currentTier,
            'progress' => $progress
        ])->layout('components.layouts.app');
    }
}
