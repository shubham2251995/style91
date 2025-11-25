<?php

namespace App\Livewire;

use Livewire\Component;

class TokenGate extends Component
{
    public $hasToken = false;

    public function checkWallet()
    {
        // Mock wallet check
        $this->hasToken = true;
        session(['dao_member' => true]);
    }

    public function render()
    {
        return view('livewire.token-gate')->layout('components.layouts.app');
    }
}
