<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MobileLogin extends Component
{
    public $countryCode = '+91';
    public $mobile = '';
    public $otp = '';
    public $step = 1; // 1: Enter Mobile, 2: Enter OTP
    public $generatedOtp;

    public function sendOtp()
    {
        $this->validate([
            'mobile' => 'required|numeric|digits:10',
        ]);

        // Simulate OTP generation
        $this->generatedOtp = '1234'; // Hardcoded for demo
        
        // In a real app, send SMS here
        // SmsService::send($this->mobile, $this->generatedOtp);

        $this->step = 2;
        $this->dispatch('otpSent');
    }

    public function verifyOtp()
    {
        $this->validate([
            'otp' => 'required|numeric|digits:4',
        ]);

        if ($this->otp !== $this->generatedOtp) {
            $this->addError('otp', 'Invalid OTP. Please try again.');
            return;
        }

        // Check if user exists, if not create
        $user = User::firstOrCreate(
            ['mobile' => $this->mobile],
            [
                'name' => 'User ' . substr($this->mobile, -4),
                'email' => null,
                'password' => null,
            ]
        );

        Auth::login($user);
        session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function back()
    {
        $this->step = 1;
        $this->otp = '';
    }

    public function render()
    {
        return view('livewire.auth.mobile-login')->layout('components.layouts.app');
    }
}
