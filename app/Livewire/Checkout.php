<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Checkout extends Component
{
    public $step = 1;
    
    // Shipping Information
    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $city = '';
    public $state = '';
    public $pincode = '';
    
    // Payment
    public $paymentMethod = 'cod';
    public $shippingMethod = 'standard';
    
    // Coupon
    public $couponCode = '';
    public $discountAmount = 0;
    
    protected $listeners = ['goToPayment' => 'advanceToPayment'];

    public function mount()
    {
        if (!app(CartService::class)->count()) {
            return redirect()->route('cart');
        }

        // Pre-fill if user is logged in
        if (Auth::check()) {
            $user = Auth::user();
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone ?? '';
        }
    }

    public function advanceToPayment()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
        ]);

        $this->step = 2;
    }

    public function applyCoupon()
    {
        // Placeholder for coupon validation
        // TODO: Implement coupon validation logic
        $this->dispatch('coupon-applied');
    }

    public function placeOrder()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string|max:15',
                'address' => 'required|string',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'pincode' => 'required|string|max:10',
                'paymentMethod' => 'required|in:cod,online',
            ]);

            $shippingAddress = "{$this->address}, {$this->city}, {$this->state} - {$this->pincode}";
            
            $shippingCost = $this->calculateShipping();

            $orderData = [
                'email' => $this->email,
                'shipping_address' => $shippingAddress,
                'shipping_phone' => $this->phone,
                'shipping_method' => $this->shippingMethod,
                'shipping_cost' => $shippingCost,
                'payment_method' => $this->paymentMethod,
                'coupon_code' => $this->couponCode,
                'discount_amount' => $this->discountAmount,
            ];

            $orderService = app(OrderService::class);
            $order = $orderService->createFromCart($orderData);

            // Process payment
            $paymentData = [
                'method' => $this->paymentMethod,
            ];
            
            $paymentResult = $orderService->processPayment($order, $paymentData);

            if ($paymentResult['success']) {
                session()->flash('success', 'Order placed successfully!');
                return redirect()->route('account.order', ['orderId' => $order->id]);
            } else {
                session()->flash('error', 'Payment failed: ' . $paymentResult['message']);
            }

        } catch (\Exception $e) {
            Log::error('Checkout failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    protected function calculateShipping()
    {
        // Simple shipping calculation
        // TODO: Implement zone-based shipping
        $cartTotal = app(CartService::class)->total();
        
        if ($cartTotal >= 2000) {
            return 0; // Free shipping over ₹2000
        }
        
        return $this->shippingMethod === 'express' ? 150 : 50;
    }

    public function render()
    {
        $cartItems = app(CartService::class)->get();
        $cartTotal = app(CartService::class)->total();
        $shippingCost = $this->calculateShipping();
        $grandTotal = $cartTotal - $this->discountAmount + $shippingCost;

        return view('livewire.checkout', [
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'shippingCost' => $shippingCost,
            'grandTotal' => $grandTotal,
        ]);
    }
}
