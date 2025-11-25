<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Referral;
use Illuminate\Support\Str;

class ReferralDashboard extends Component
{
    public $referralLink;
    public $email;

    public function mount()
    {
        $user = Auth::user();
        if (!$user->referral_code) {
            $user->referral_code = Str::upper(Str::random(8));
            $user->save();
        }
        $this->referralLink = route('register', ['ref' => $user->referral_code]);
    }

    public function sendInvite()
    {
        $this->validate(['email' => 'required|email']);

        Referral::create([
            'referrer_id' => Auth::id(),
            'referral_code' => Auth::user()->referral_code,
            'email' => $this->email,
            'status' => 'pending',
        ]);

        // Mock sending email
        session()->flash('message', 'Invitation sent to ' . $this->email);
        $this->email = '';
    }

    public function render()
    {
        $referrals = Referral::where('referrer_id', Auth::id())
            ->with('referredUser')
            ->latest()
            ->get();

        return view('livewire.referral-dashboard', [
            'referrals' => $referrals,
        ]);
    }
}
