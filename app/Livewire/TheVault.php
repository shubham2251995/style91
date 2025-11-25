<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class TheVault extends Component
{
    public $password = '';
    public $isUnlocked = false;
    public $error = '';

    public function mount()
    {
        $this->isUnlocked = Session::get('vault_unlocked', false);
    }

    public function unlock()
    {
        // Hardcoded password for demo
        if ($this->password === 'SINGULARITY') {
            Session::put('vault_unlocked', true);
            $this->isUnlocked = true;
            $this->error = '';
        } else {
            $this->error = 'Access Denied.';
            $this->password = '';
        }
    }

    public function render()
    {
        $products = [];
        if ($this->isUnlocked) {
            // In a real app, these would be products flagged as 'exclusive' or 'vault'
            $products = Product::latest()->take(4)->get(); 
        }

        return view('livewire.the-vault', [
            'products' => $products
        ])->layout('components.layouts.app');
    }
}
