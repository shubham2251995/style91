<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            // Verify admin role
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                $this->addError('email', 'You do not have admin privileges.');
                return;
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        $this->addError('email', 'Invalid credentials.');
    }

    public function render()
    {
        return view('livewire.auth.admin-login')->layout('components.layouts.app');
    }
}
