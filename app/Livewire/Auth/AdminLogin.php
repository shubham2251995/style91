<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminLogin extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $errorMessage = '';

    public function login()
    {
        $this->errorMessage = '';
        
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        Log::info('Admin login attempt', [
            'email' => $this->email,
            'remember' => $this->remember
        ]);

        // Attempt authentication
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $user = Auth::user();
            
            Log::info('Authentication successful', [
                'user_id' => $user->id,
                'role' => $user->role ?? 'NOT_SET'
            ]);

            // Verify admin role
            if ($user->role !== 'admin') {
                Auth::logout();
                Log::warning('Admin login denied - insufficient privileges', [
                    'user_id' => $user->id,
                    'role' => $user->role ?? 'NOT_SET'
                ]);
                $this->errorMessage = 'You do not have admin privileges.';
                $this->addError('email', 'You do not have admin privileges.');
                return;
            }

            session()->regenerate();
            
            Log::info('Admin login successful', ['user_id' => $user->id]);

            return redirect()->intended(route('admin.dashboard'));
        }

        Log::warning('Admin login failed - invalid credentials', [
            'email' => $this->email
        ]);
        
        $this->errorMessage = 'Invalid email or password.';
        $this->addError('email', 'Invalid email or password.');
    }

    public function render()
    {
        return view('livewire.auth.admin-login')->layout('components.layouts.app');
    }
}
