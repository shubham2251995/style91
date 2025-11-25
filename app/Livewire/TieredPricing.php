<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PriceTier;

class TieredPricing extends Component
{
    public $tiers;

    public function mount()
    {
        $this->tiers = PriceTier::orderBy('min_quantity')->get();
    }

    public function render()
    {
        return view('livewire.tiered-pricing');
    }
}
