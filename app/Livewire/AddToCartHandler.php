<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\CartService;

class AddToCartHandler extends Component
{
    #[On('add-to-cart')]
    public function addToCart($productId)
    {
        try {
            app(CartService::class)->add($productId, 1);
            
            // Dispatch cart updated event
            $this->dispatch('cart-updated');
            $this->dispatch('cartUpdated');
            
            // Show success message
            $this->dispatch('cart-item-added', productId: $productId);
            
        } catch (\Exception $e) {
            \Log::error('Add to cart failed: ' . $e->getMessage());
            $this->dispatch('cart-error', message: 'Failed to add item to cart');
        }
    }

    public function render()
    {
        return view('livewire.add-to-cart-handler');
    }
}
