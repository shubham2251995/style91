<?php

namespace App\Livewire\Lookbook;

use Livewire\Component;
use App\Models\Lookbook;
use App\Services\CartService;

class Show extends Component
{
    public Lookbook $lookbook;
    public $activeItem = null;

    public function mount($slug)
    {
        $this->lookbook = Lookbook::where('slug', $slug)->with('items.product')->firstOrFail();
    }

    public function setActiveItem($itemId)
    {
        $this->activeItem = $itemId;
    }

    public function addToCart($productId, CartService $cartService)
    {
        $cartService->add($productId, 1);
        $this->dispatch('cart-updated');
        session()->flash('message', 'Added to cart');
    }

    public function render()
    {
        return view('livewire.lookbook.show')->layout('components.layouts.app');
    }
}
