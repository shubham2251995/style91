<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;
use App\Services\PluginManager;
use Illuminate\Support\Facades\Log;

class Cart extends Component
{
    public function getCartItemsProperty()
    {
        return app(CartService::class)->get();
    }

    public function getTotalProperty()
    {
        return app(CartService::class)->total();
    }

    public function getTieredTotalProperty()
    {
        return app(CartService::class)->getTieredTotal();
    }

    public function getDiscountProperty()
    {
        return app(CartService::class)->getTotalDiscount();
    }

    public function getCartCountProperty()
    {
        try {
            return app(CartService::class)->count();
        } catch (\Exception $e) {
            Log::error('Error getting cart count: ' . $e->getMessage());
            return 0;
        }
    }

    public function getTieredPricingActiveProperty()
    {
        try {
            return app(PluginManager::class)->isActive('tiered_pricing');
        } catch (\Exception $e) {
            Log::error('Error checking tiered pricing plugin: ' . $e->getMessage());
            return false;
        }
    }

    public function getQuoteEngineActiveProperty()
    {
        try {
            return app(PluginManager::class)->isActive('quote_engine');
        } catch (\Exception $e) {
            Log::error('Error checking quote engine plugin: ' . $e->getMessage());
            return false;
        }
    }

    public function getFreeShippingThresholdProperty()
    {
        return 1000; // Hardcoded for now, could be dynamic setting
    }

    public function getFreeShippingProgressProperty()
    {
        $total = $this->total;
        $threshold = $this->freeShippingThreshold;
        
        if ($total >= $threshold) {
            return 100;
        }
        
        return ($total / $threshold) * 100;
    }

    public function getAmountLeftForFreeShippingProperty()
    {
        return max(0, $this->freeShippingThreshold - $this->total);
    }

    public function increment($itemId)
    {
        $cart = app(CartService::class)->get();
        if (isset($cart[$itemId])) {
            app(CartService::class)->updateQuantity($itemId, $cart[$itemId]['quantity'] + 1);
        }
    }

    public function decrement($productId)
    {
        $cart = app(CartService::class)->get();
        if (isset($cart[$productId])) {
            app(CartService::class)->updateQuantity($productId, $cart[$productId]['quantity'] - 1);
        }
    }

    public function remove($productId)
    {
        app(CartService::class)->remove($productId);
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
