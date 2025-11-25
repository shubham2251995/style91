<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class ReferralDashboard extends Component
{
    public $referralCode;
    public $referrals;
    public $stats;

    public function mount()
    {
        $user = auth()->user();
        
        // Generate referral code if not exists
        if (!$user->referral_code) {
            $user->referral_code = strtoupper(substr($user->name, 0, 3) . rand(1000, 9999));
            $user->save();
        }

        $this->referralCode = $user->referral_code;
        $this->loadReferrals();
    }

    public function loadReferrals()
    {
        $userId = auth()->id();
        
        $this->referrals = \App\Models\Referral::where('referrer_id', $userId)
            ->with('referred')
            ->latest()
            ->get();

        $this->stats = [
            'total' => $this->referrals->count(),
            'pending' => $this->referrals->where('status', 'pending')->count(),
            'completed' => $this->referrals->where('status', 'completed')->count(),
            'total_earned' => $this->referrals->where('status', 'rewarded')->sum('referrer_reward'),
        ];
    }

    public function copyCode()
    {
        $this->dispatch('code-copied');
    }

    public function render()
    {
        return view('livewire.referral-dashboard');
    }
}
