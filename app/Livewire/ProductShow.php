<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Services\CartService;
use App\Services\PluginManager;
use Illuminate\Support\Facades\Log;

class ProductShow extends Component
{
    public Product $product;
    public $added = false;
    public $selectedVariant = null;
    public $quantity = 1;
    
    // SEO Meta Tags
    public $metaTitle;
    public $metaDescription;
    public $ogImage;

    public function mount($slug)
    {
        $this->product = Product::with(['category', 'variants', 'reviews.user'])->where('slug', $slug)->firstOrFail();
        
        // Track recently viewed
        $viewed = session('recently_viewed', []);
        $productId = $this->product->id;
        
        // Remove if already exists (to re-add at front)
        $viewed = array_diff($viewed, [$productId]);
        
        // Add to beginning
        array_unshift($viewed, $productId);
        
        // Keep only last 12
        $viewed = array_slice($viewed, 0, 12);
        
        session(['recently_viewed' => $viewed]);
    }

    public function addToCart()
    {
        app(CartService::class)->add($this->product->id);
        $this->added = true;
        
        // Reset button state after 2 seconds
        $this->dispatch('cart-updated'); // Optional: if we want to refresh cart count elsewhere
    }

    // Safe plugin check properties
    public function getDigitalWardrobeActiveProperty()
    {
        try {
            return app(PluginManager::class)->isActive('digital_wardrobe');
        } catch (\Exception $e) {
            Log::error('Error checking digital_wardrobe plugin: ' . $e->getMessage());
            return false;
        }
    }

    public function getStockAlertActiveProperty()
    {
        try {
            return app(PluginManager::class)->isActive('stock_alert');
        } catch (\Exception $e) {
            Log::error('Error checking stock_alert plugin: ' . $e->getMessage());
            return false;
        }
    }

    public function getTieredPricingActiveProperty()
    {
        try {
            return app(PluginManager::class)->isActive('tiered_pricing');
        } catch (\Exception $e) {
            Log::error('Error checking tiered_pricing plugin: ' . $e->getMessage());
            return false;
        }
    }

    public function getSocialUnlockActiveProperty()
    {
        try {
            return app(PluginManager::class)->isActive('social_unlock');
        } catch (\Exception $e) {
            Log::error('Error checking social_unlock plugin: ' . $e->getMessage());
            return false;
        }
    }

    public function getCrowdDropActiveProperty()
    {
        try {
            return app(PluginManager::class)->isActive('crowd_drop');
        } catch (\Exception $e) {
            Log::error('Error checking crowd_drop plugin: ' . $e->getMessage());
            return false;
        }
    }

    public function getFitCheckActiveProperty()
    {
        try {
            return app(PluginManager::class)->isActive('fit_check');
        } catch (\Exception $e) {
            Log::error('Error checking fit_check plugin: ' . $e->getMessage());
            return false;
        }
    }

    public function getSquadModeActiveProperty()
    {
        try {
            return app(PluginManager::class)->isActive('squad_mode');
        } catch (\Exception $e) {
            Log::error('Error checking squad_mode plugin: ' . $e->getMessage());
            return false;
        }
    }

    public function getRafflesActiveProperty()
    {
        try {
            return app(PluginManager::class)->isActive('raffles');
        } catch (\Exception $e) {
            Log::error('Error checking raffles plugin: ' . $e->getMessage());
            return false;
        }
    }

    public function getSmartBundlingActiveProperty()
    {
        try {
            return app(PluginManager::class)->isActive('smart_bundling');
        } catch (\Exception $e) {
            Log::error('Error checking smart_bundling plugin: ' . $e->getMessage());
            return false;
        }
    }

    public function render()
    {
        return view('livewire.product-show');
    }
}
