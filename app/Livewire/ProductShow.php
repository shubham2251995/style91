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
    
    // Variant Properties
    public $selectedOptions = [];
    public $variantPrice;
    public $variantStock;
    public $variantId;
    public $availableOptions = [];
    
    public $selectedSize = null;
    public $selectedColor = null;
    public $completeTheLookProducts = [];
    
    // SEO Meta Tags
    public $metaTitle;
    public $metaDescription;
    public $ogImage;

    public function mount($slug)
    {
        $this->product = Product::with(['category', 'images', 'variants', 'reviews.user'])->where('slug', $slug)->firstOrFail();
        
        // AI Stylist
        $stylist = app(\App\Services\AiStylistService::class);
        $this->completeTheLookProducts = $stylist->completeTheLook($this->product);
        
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

        // Initialize variants
        $this->availableOptions = $this->product->variantOptions->map(function($opt) {
            return [
                'name' => $opt->name,
                'values' => $opt->values,
            ];
        })->toArray();

        if ($this->product->hasVariants()) {
            $firstVariant = $this->product->variants()->where('is_active', true)->first();
            if ($firstVariant) {
                $this->selectedOptions = $firstVariant->options;
                $this->updateVariantInfo();
            } else {
                // No active variants
                $this->variantPrice = $this->product->price;
                $this->variantStock = 0;
            }
        } else {
            $this->variantPrice = $this->product->price;
            $this->variantStock = $this->product->stock_quantity;
        }
    }

    public function updatedSelectedOptions()
    {
        $this->updateVariantInfo();
    }

    public function updateVariantInfo()
    {
        $variant = $this->product->variants()
            ->where('is_active', true)
            ->get()
            ->first(function($v) {
                // Compare arrays (order independent)
                return empty(array_diff_assoc($v->options, $this->selectedOptions)) && 
                       empty(array_diff_assoc($this->selectedOptions, $v->options));
            });

        if ($variant) {
            $this->variantId = $variant->id;
            $this->variantPrice = $variant->price ?? $this->product->price;
            $this->variantStock = $variant->stock_quantity;
        } else {
            $this->variantId = null;
            $this->variantPrice = $this->product->price;
            $this->variantStock = 0; // Unavailable combination
        }
    }

    public function addToCart()
    {
        if ($this->product->hasVariants() && !$this->variantId) {
            // Should probably show error, but UI should prevent this
            return;
        }

        app(CartService::class)->add($this->product->id, $this->quantity, $this->variantId);
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
