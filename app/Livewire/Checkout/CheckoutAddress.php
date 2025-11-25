<?php

namespace App\Livewire\Checkout;

use Livewire\Component;
use App\Models\Address;
use App\Models\ShippingMethod;
use Illuminate\Support\Facades\Auth;

class CheckoutAddress extends Component
{
    public $step = 'address'; // address, shipping, review
    
    // Address fields
    public $selectedAddressId;
    public $showAddressForm = false;
    public $label = '';
    public $fullName = '';
    public $phone = '';
    public $email = '';
    public $addressLine1 = '';
    public $addressLine2 = '';
    public $city = '';
    public $state = '';
    public $postcode = '';
    public $country = 'IN';
    public $isDefault = false;
    
    // Shipping
    public $selectedShippingMethodId;
    public $shippingCost = 0;
    
    // Coupon
    public $couponCode = '';
    public $discount = 0;

    protected $rules = [
        'fullName' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'addressLine1' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'postcode' => 'required|string|max:10',
    ];

    public function mount()
    {
        if (Auth::check()) {
            // Load user's default address
            $defaultAddress = Auth::user()->addresses()->default()->first();
            if ($defaultAddress) {
                $this->selectAddress($defaultAddress->id);
            }
        }
    }

    public function selectAddress($addressId)
    {
        $address = Address::findOrFail($addressId);
        $this->selectedAddressId = $addressId;
        $this->fullName = $address->full_name;
        $this->phone = $address->phone;
        $this->email = $address->email;
        $this->addressLine1 = $address->address_line_1;
        $this->addressLine2 = $address->address_line_2;
        $this->city = $address->city;
        $this->state = $address->state;
        $this->postcode = $address->postcode;
        $this->country = $address->country;
        $this->showAddressForm = false;
    }

    public function saveAddress()
    {
        $this->validate();

        if (Auth::check()) {
            $address = Address::create([
                'user_id' => Auth::id(),
                'label' => $this->label,
                'full_name' => $this->fullName,
                'phone' => $this->phone,
                'email' => $this->email,
                'address_line_1' => $this->addressLine1,
                'address_line_2' => $this->addressLine2,
                'city' => $this->city,
                'state' => $this->state,
                'postcode' => $this->postcode,
                'country' => $this->country,
                'is_default' => $this->isDefault,
            ]);

            $this->selectAddress($address->id);
            session()->flash('message', 'Address saved successfully!');
        }

        $this->showAddressForm = false;
    }

    public function continueToShipping()
    {
        $this->validate();
        
        // Store address in session for guest checkout
        session(['checkout_address' => [
            'full_name' => $this->fullName,
            'phone' => $this->phone,
            'email' => $this->email,
            'address_line_1' => $this->addressLine1,
            'address_line_2' => $this->addressLine2,
            'city' => $this->city,
            'state' => $this->state,
            'postcode' => $this->postcode,
            'country' => $this->country,
        ]]);

        $this->step = 'shipping';
    }

    public function selectShippingMethod($methodId)
    {
        $method = ShippingMethod::findOrFail($methodId);
        $this->selectedShippingMethodId = $methodId;
        $this->shippingCost = $method->cost;
        
        session(['checkout_shipping_method' => $methodId]);
    }

    public function continueToReview()
    {
        if (!$this->selectedShippingMethodId) {
            session()->flash('error', 'Please select a shipping method');
            return;
        }

        $this->step = 'review';
    }

    public function applyCoupon()
    {
        $coupon = \App\Models\Coupon::where('code', $this->couponCode)
                                     ->where('is_active', true)
                                     ->where('expiry_date', '>=', now())
                                     ->first();

        if (!$coupon) {
            session()->flash('error', 'Invalid or expired coupon code');
            return;
        }

        // Calculate discount
        $cartTotal = $this->getCartTotal();
        
        if ($coupon->min_order_value && $cartTotal < $coupon->min_order_value) {
            session()->flash('error', 'Minimum order value of ₹' . $coupon->min_order_value . ' required');
            return;
        }

        if ($coupon->type === 'percentage') {
            $this->discount = ($cartTotal * $coupon->value) / 100;
        } else {
            $this->discount = $coupon->value;
        }

        session(['checkout_coupon' => $this->couponCode]);
        session()->flash('message', 'Coupon applied successfully!');
    }

    public function proceedToPayment()
    {
        $cartTotal = $this->getCartTotal();
        $finalTotal = $cartTotal + $this->shippingCost - $this->discount;

        session(['pending_order' => [
            'total' => $finalTotal,
            'subtotal' => $cartTotal,
            'shipping_cost' => $this->shippingCost,
            'discount' => $this->discount,
            'shipping_name' => $this->fullName,
            'shipping_phone' => $this->phone,
            'shipping_email' => $this->email,
            'shipping_address' => $this->addressLine1 . ($this->addressLine2 ? ', ' . $this->addressLine2 : ''),
            'shipping_city' => $this->city,
            'shipping_state' => $this->state,
            'shipping_postcode' => $this->postcode,
            'shipping_country' => $this->country,
        ]]);

        $this->dispatch('goToPayment');
    }

    private function getCartTotal()
    {
        // This should get the actual cart total from your cart system
        return session('cart_total', 0);
    }

    public function render()
    {
        $addresses = Auth::check() ? Auth::user()->addresses : collect();
        $shippingMethods = ShippingMethod::active()->get();
        $cartItems = session('cart', []);
        $cartTotal = $this->getCartTotal();
        $finalTotal = $cartTotal + $this->shippingCost - $this->discount;

        return view('livewire.checkout.checkout-address', [
            'addresses' => $addresses,
            'shippingMethods' => $shippingMethods,
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'finalTotal' => $finalTotal,
        ]);
    }
}
