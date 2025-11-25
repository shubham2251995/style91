<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\PriceTier;

class PriceTiers extends Component
{
    public $min_quantity;
    public $discount_percentage;

    public function addTier()
    {
        $this->validate([
            'min_quantity' => 'required|integer|min:1',
            'discount_percentage' => 'required|numeric|min:0|max:100',
        ]);

        PriceTier::create([
            'product_id' => null, // Global
            'min_quantity' => $this->min_quantity,
            'discount_percentage' => $this->discount_percentage,
        ]);

        $this->reset(['min_quantity', 'discount_percentage']);
    }

    public function delete($id)
    {
        PriceTier::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.price-tiers', [
            'tiers' => PriceTier::whereNull('product_id')->orderBy('min_quantity')->get()
        ])->layout('components.layouts.admin');
    }
}
