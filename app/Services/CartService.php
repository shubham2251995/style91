<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CartService
{
    const SESSION_KEY = 'cart';

    public function add($productId, $quantity = 1, $variantId = null)
    {
            Log::info("Adding product to cart", ['productId' => $productId, 'variantId' => $variantId]);
            $cart = $this->get();
            $cartKey = $productId . ($variantId ? '_' . $variantId : '');

            if (empty($cart)) {
                session()->put('cart_expires_at', now()->addMinutes(10));
            }

            if (isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity'] += $quantity;
            } else {
                $product = Product::find($productId);
                if (!$product) {
                    Log::warning("Product not found for ID {$productId}");
                    return;
                }

                $price = $product->price;
                $options = [];
                $variantSku = null;

                if ($variantId) {
                    $variant = \App\Models\ProductVariant::find($variantId);
                    if ($variant) {
                        $price = $variant->price ?? $product->price;
                        $options = $variant->options;
                        $variantSku = $variant->sku;
                    }
                }

                $cart[$cartKey] = [
                    'id' => $product->id,
                    'variant_id' => $variantId,
                    'name' => $product->name,
                    'price' => $price,
                    'image_url' => $product->image_url,
                    'quantity' => $quantity,
                    'slug' => $product->slug,
                    'options' => $options,
                    'sku' => $variantSku,
                ];
            }

            Session::put(self::SESSION_KEY, $cart);
            Log::info("Cart updated successfully", ['count' => count($cart)]);
        } catch (\Exception $e) {
            Log::error('Error adding product to cart: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    public function remove($key)
    {
        try {
            $cart = Session::get(self::SESSION_KEY, []);
            if (isset($cart[$key])) {
                unset($cart[$key]);
                Session::put(self::SESSION_KEY, $cart);
            }
        } catch (\Exception $e) {
            Log::error('Error removing product from cart: ' . $e->getMessage());
        }
    }

    public function updateQuantity($key, $quantity)
    {
        try {
            $cart = Session::get(self::SESSION_KEY, []);
            if (isset($cart[$key])) {
                $cart[$key]['quantity'] = $quantity;
                if ($cart[$key]['quantity'] <= 0) {
                    unset($cart[$key]);
                }
                Session::put(self::SESSION_KEY, $cart);
            }
        } catch (\Exception $e) {
            Log::error('Error updating product quantity in cart: ' . $e->getMessage());
        }
    }

    public function get()
    {
        try {
            if (app(\App\Services\PluginManager::class)->isActive('cart_timer')) {
                $expiresAt = session()->get('cart_expires_at');
                if ($expiresAt && now()->greaterThan($expiresAt)) {
                    $this->clear();
                    session()->forget('cart_expires_at');
                }
            }
            return Session::get(self::SESSION_KEY, []);
        } catch (\Exception $e) {
            Log::error('Error getting cart contents: ' . $e->getMessage());
            return [];
        }
    }

    public function total()
    {
        try {
            $cart = $this->get();
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            return $total;
        } catch (\Exception $e) {
            Log::error('Error calculating cart total: ' . $e->getMessage());
            return 0;
        }
    }

    public function getTieredTotal()
    {
        try {
            if (!app(\App\Services\PluginManager::class)->isActive('tiered_pricing')) {
                return $this->total();
            }

            $cart = $this->get();
            if (empty($cart)) {
                return 0;
            }

            $productIds = array_keys($cart);
            
            // Fetch all relevant tiers in one query
            $tiers = \App\Models\PriceTier::whereIn('product_id', $productIds)
                ->orWhereNull('product_id')
                ->get()
                ->groupBy('product_id');

            $total = 0;
            foreach ($cart as $productId => $item) {
                $quantity = $item['quantity'];
                
                // Find best tier: Specific product tiers first, then global (null key)
                $productTiers = $tiers->get($productId, collect());
                $globalTiers = $tiers->get('', collect()); // Empty string key for null in groupBy? Check Laravel behavior, usually "" or null
                
                // Merge and sort
                $applicableTiers = $productTiers->merge($globalTiers)
                    ->where('min_quantity', '<=', $quantity)
                    ->sortByDesc('min_quantity');

                $discount = $applicableTiers->first()->discount_percentage ?? 0;
                
                $discountedPrice = $item['price'] * (1 - ($discount / 100));
                $total += $discountedPrice * $quantity;
            }
            return $total;
        } catch (\Exception $e) {
            Log::error('Error calculating tiered cart total: ' . $e->getMessage());
            return $this->total();
        }
    }

    public function getTotalDiscount()
    {
        try {
            return $this->total() - $this->getTieredTotal();
        } catch (\Exception $e) {
            Log::error('Error calculating total cart discount: ' . $e->getMessage());
            return 0;
        }
    }

    public function count()
    {
        try {
            $cart = $this->get();
            return array_sum(array_column($cart, 'quantity'));
        } catch (\Exception $e) {
            Log::error('Error counting cart items: ' . $e->getMessage());
            return 0;
        }
    }

    public function clear()
    {
        try {
            Session::forget(self::SESSION_KEY);
            Session::forget('cart_expires_at');
        } catch (\Exception $e) {
            Log::error('Error clearing cart: ' . $e->getMessage());
        }
    }
}
