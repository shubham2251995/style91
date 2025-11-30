<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;

class QuickAddToCart extends Component
{
    public $productId;
    public $added = false;

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function addToCart()
    {
        app(CartService::class)->add($this->productId, 1);
        $this->added = true;
        $this->dispatch('cart-updated');
        
        // Open cart drawer to show the added item
        $this->dispatch('cartUpdated')->to(CartDrawer::class);

        // Reset after 2 seconds
        $this->dispatch('reset-button', id: $this->productId);
    }

    public function render()
    {
        return view('livewire.quick-add-to-cart');
    }
}
