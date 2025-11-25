<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;

class RemixStudio extends Component
{
    use WithFileUploads;

    public $product;
    public $stickers = [
        '🔥', '💀', '⚡', '💎', 'US7', 'LIMITED'
    ];

    public function mount($productId = null)
    {
        if ($productId) {
            $this->product = Product::find($productId);
        } else {
            $this->product = Product::first(); // Default to first for demo
        }
    }

    public function render()
    {
        return view('livewire.remix-studio')->layout('components.layouts.app');
    }
}
