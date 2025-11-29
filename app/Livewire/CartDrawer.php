<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CartDrawer extends Component
{
    public $isOpen = false;
    public $promoCode = '';
    
    protected $listeners = [
        'openCart' => 'open',
        'closeCart' => 'close',
        'cartUpdated' => '$refresh',
        'productAddedToCart' => 'open'
    ];

    public function open()
    {
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function getCartItemsProperty()
    {
        return app(CartService::class)->get();
    }

    public function getSavedItemsProperty()
    {
        return app(CartService::class)->getSaved();
    }

    public function getTotalProperty()
    {
        return app(CartService::class)->total();
    }

    public function getCartCountProperty()
    {
        return app(CartService::class)->count();
    }

    public function getFreeShippingThresholdProperty()
    {
        return 1000; // Configurable
    }

    public function getFreeShippingProgressProperty()
    {
        $total = $this->total;
        $threshold = $this->freeShippingThreshold;
        
        if ($total >= $threshold) return 100;
        return ($total / $threshold) * 100;
    }

    public function getAmountLeftForFreeShippingProperty()
    {
        return max(0, $this->freeShippingThreshold - $this->total);
    }

    public function getRecommendationsProperty()
    {
        // Simple recommendation logic: random products not in cart
        $cartIds = collect($this->cartItems)->pluck('id')->toArray();
        return Product::whereNotIn('id', $cartIds)
            ->inRandomOrder()
            ->take(3)
            ->get();
    }

    public function increment($key)
    {
        $cart = $this->cartItems;
        if (isset($cart[$key])) {
            app(CartService::class)->updateQuantity($key, $cart[$key]['quantity'] + 1);
            $this->dispatch('cartUpdated');
        }
    }

    public function decrement($key)
    {
        $cart = $this->cartItems;
        if (isset($cart[$key])) {
            app(CartService::class)->updateQuantity($key, $cart[$key]['quantity'] - 1);
            $this->dispatch('cartUpdated');
        }
    }

    public function remove($key)
    {
        app(CartService::class)->remove($key);
        $this->dispatch('cartUpdated');
    }

    public function saveForLater($key)
    {
        app(CartService::class)->saveForLater($key);
        $this->dispatch('cartUpdated');
    }

    public function moveToCart($key)
    {
        app(CartService::class)->moveToCart($key);
        $this->dispatch('cartUpdated');
    }

    public function removeSaved($key)
    {
        app(CartService::class)->removeSaved($key);
        $this->dispatch('cartUpdated');
    }
    
    public function addToCart($productId)
    {
        app(CartService::class)->add($productId);
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.cart-drawer');
    }
}
