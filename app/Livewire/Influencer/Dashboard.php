<?php

namespace App\Livewire\Influencer;

use Livewire\Component;
use App\Models\Influencer;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $influencer;

    public function mount()
    {
        $this->influencer = Influencer::where('user_id', Auth::id())->first();

        if (!$this->influencer) {
            return redirect()->route('influencer.register');
        }
    }

    public function render()
    {
        return view('livewire.influencer.dashboard')->layout('components.layouts.app');
    }
}
