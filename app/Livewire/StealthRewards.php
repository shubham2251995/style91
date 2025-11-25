<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class StealthRewards extends Component
{
    public $showPopup = false;
    public $code = '';

    protected $listeners = ['unlockStealthReward' => 'unlock'];

    public function unlock()
    {
        $this->showPopup = true;
        $this->code = 'KONAMI-' . strtoupper(str()->random(6));
        // In a real app, we'd save this code to the database or session
        Session::put('stealth_discount', 15); // 15% off
    }

    public function close()
    {
        $this->showPopup = false;
    }

    public function render()
    {
        return view('livewire.stealth-rewards');
    }
}
