<?php

namespace App\Livewire\Checkout;

use Livewire\Component;
use App\Services\CartService;
use App\Services\ShippingService;

class OrderSummary extends Component
{
    public $cart;
    public $subtotal = 0;
    public $shipping = 0;
    public $tax = 0;
    public $discount = 0;
    public $total = 0;
    public $couponCode = '';

    protected $listeners = ['cart-updated' => 'refreshCart'];

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        $cartService = app(CartService::class);
        $this->cart = $cartService->get();
        
        // Calculate totals
        $this->subtotal = $cartService->getTotal();
        $this->discount = $cartService->getTotalDiscount();
        
        // Shipping (mock - real calculation would be in checkout flow)
        $this->shipping = $this->subtotal > 999 ? 0 : 99;
        
        // Tax (18% GST)
        $this->tax = ($this->subtotal - $this->discount) * 0.18;
        
        // Total
        $this->total = $this->subtotal - $this->discount + $this->shipping + $this->tax;
    }

    public function render()
    {
        return view('livewire.checkout.order-summary');
    }
}
