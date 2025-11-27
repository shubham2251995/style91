<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OrderService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Create an order from cart
     */
    public function createFromCart(array $data)
    {
        try {
            DB::beginTransaction();

            // Get cart items
            $cartItems = $this->cartService->get();
            
            if (empty($cartItems)) {
                throw new \Exception('Cart is empty');
            }

            // Calculate totals
            $subtotal = $this->cartService->total();
            $discountAmount = $data['discount_amount'] ?? 0;
            $shippingCost = $data['shipping_cost'] ?? 0;
            $totalAmount = $subtotal - $discountAmount + $shippingCost;

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'guest_email' => $data['email'] ?? (auth()->check() ? auth()->user()->email : null),
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'coupon_code' => $data['coupon_code'] ?? null,
                'shipping_address' => $data['shipping_address'],
                'shipping_phone' => $data['shipping_phone'],
                'shipping_method' => $data['shipping_method'] ?? 'standard',
                'shipping_cost' => $shippingCost,
                'payment_method' => $data['payment_method'] ?? 'cod',
                'payment_status' => 'pending',
            ]);

            // Create order items and reduce stock
            foreach ($cartItems as $productId => $item) {
                $product = Product::find($productId);
                
                if (!$product) {
                    throw new \Exception("Product not found: {$productId}");
                }

                // Check stock availability
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'variant_id' => $item['variant_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'product_name' => $product->name,
                ]);

                // Reduce stock
                $product->decrement('stock_quantity', $item['quantity']);
            }

            // Clear cart
            $this->cartService->clear();

            DB::commit();

            // Send confirmation email
            try {
                if ($order->user) {
                    Mail::to($order->user->email)->send(new OrderConfirmation($order));
                } elseif ($order->guest_email) {
                    Mail::to($order->guest_email)->send(new OrderConfirmation($order));
                }
            } catch (\Exception $e) {
                Log::error('Failed to send order confirmation email: ' . $e->getMessage());
            }

            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update order status
     */
    public function updateStatus(Order $order, string $status)
    {
        $order->update(['status' => $status]);

        // Send status-specific emails
        if ($status === 'shipped' && $order->user) {
            Mail::to($order->user->email)->send(new \App\Mail\OrderShipped($order));
        } elseif ($status === 'delivered' && $order->user) {
            Mail::to($order->user->email)->send(new \App\Mail\OrderDelivered($order));
        }

        return $order;
    }

    /**
     * Process payment
     */
    public function processPayment(Order $order, array $paymentData)
    {
        // This is a placeholder for payment gateway integration
        // Implement Razorpay, Stripe, or other payment gateway here
        
        try {
            if ($paymentData['method'] === 'cod') {
                $order->update([
                    'payment_status' => 'pending',
                    'status' => 'processing',
                ]);
                return ['success' => true, 'message' => 'Cash on Delivery order placed'];
            }

            // For online payments, integrate with payment gateway
            // Example: Razorpay integration would go here
            
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
                'payment_id' => $paymentData['payment_id'] ?? null,
            ]);

            return ['success' => true, 'message' => 'Payment processed successfully'];

        } catch (\Exception $e) {
            Log::error('Payment processing failed: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
