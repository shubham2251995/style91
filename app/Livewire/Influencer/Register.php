<?php

namespace App\Livewire\Influencer;

use Livewire\Component;
use App\Models\Influencer;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    public $code;

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Influencer::where('user_id', Auth::id())->exists()) {
            return redirect()->route('influencer.dashboard');
        }
    }

    public function register()
    {
        $this->validate([
            'code' => 'required|unique:influencers,code|alpha_num|min:3|max:15',
        ]);

        Influencer::create([
            'user_id' => Auth::id(),
            'code' => strtoupper($this->code),
            'status' => 'pending',
        ]);

        return redirect()->route('influencer.dashboard');
    }

    public function render()
    {
        return view('livewire.influencer.register')->layout('components.layouts.app');
    }
}
