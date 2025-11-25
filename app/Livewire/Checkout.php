<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;
use App\Services\FraudDetectionService;
use App\Models\GiftCard;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Checkout extends Component
{
    public $step = 1;
    
    public $email = '';
    public $shipping = [
        'name' => '',
        'address' => '',
        'city' => '',
        'zip' => '',
        'country' => 'US'
    ];
    
    public $payment_method = 'card';

    public $currentStep = 'shipping';
    public $couponCode = '';
    public $appliedCoupon = null;
    public $couponError = '';

    // Gift Card
    public $giftCardCode = '';
    public $appliedGiftCard = null;
    public $giftCardError = '';

    public $activeGateways = [];

    public function mount()
    {
        if (!app(CartService::class)->count()) {
            return redirect()->route('cart');
        }

        if (Auth::check()) {
            $this->email = Auth::user()->email;
            $this->shipping['name'] = Auth::user()->name;
        }

        try {
            $this->activeGateways = \App\Models\PaymentGateway::where('is_active', true)->get();
            
            // Default to first active gateway if available
            if ($this->activeGateways->isNotEmpty()) {
                $this->payment_method = $this->activeGateways->first()->slug;
            }
        } catch (\Exception $e) {
            // If DB unavailable, default to COD
            $this->payment_method = 'cod';
        }
    }

    public function nextStep()
    {
        if ($this->step == 1) {
            $this->validate([
                'email' => 'required|email',
                'shipping.name' => 'required',
                'shipping.address' => 'required',
                'shipping.city' => 'required',
                'shipping.zip' => 'required',
            ]);
        }
        
        $this->step++;
    }

    public function prevStep()
    {
        $this->step--;
    }

    public function applyGiftCard()
    {
        $this->giftCardError = '';

        $card = GiftCard::where('code', $this->giftCardCode)->first();

        if (!$card) {
            $this->giftCardError = 'Invalid gift card code';
            return;
        }

        if (!$card->isValid()) {
            $this->giftCardError = $card->isExpired() ? 'Gift card expired' : 'Gift card inactive';
            return;
        }

        if ($card->balance <= 0) {
            $this->giftCardError = 'Gift card has no balance';
            return;
        }

        $this->appliedGiftCard = $card;
        session()->flash('success', 'Gift card applied! Balance: $' . number_format($card->balance, 2));
    }

    public function removeGiftCard()
    {
        $this->appliedGiftCard = null;
        $this->giftCardCode = '';
        $this->giftCardError = '';
    }

    public function placeOrder()
    {
        $cartService = app(CartService::class);
        $cartItems = $cartService->get();
        $subtotal = $cartService->total();

        if (empty($this->payment_method)) {
            $this->addError('payment_method', 'Please select a payment method.');
            return;
        }
        
        try {
            // 1. Calculate Membership Discount
            $membershipService = new \App\Services\MembershipService();
            $discountAmount = 0;
            if (Auth::check()) {
                $discountAmount = $membershipService->calculateDiscount(Auth::user(), $subtotal);
            }
            $finalTotal = $subtotal - $discountAmount;

            // 2. Check for Influencer Referral
            $influencerId = null;
            $referralCode = \Illuminate\Support\Facades\Cookie::get('referral_code');
            if ($referralCode) {
                $influencer = \App\Models\Influencer::where('code', $referralCode)->first();
                if ($influencer) {
                    $influencerId = $influencer->id;
                }
            }

            $orderId = DB::transaction(function () use ($cartItems, $subtotal, $finalTotal, $discountAmount, $influencerId, $cartService, $membershipService) {
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'guest_email' => $this->email,
                    'status' => 'pending',
                    'total' => $finalTotal,
                    'discount_amount' => $discountAmount,
                    'influencer_id' => $influencerId,
                    'shipping_address' => json_encode($this->shipping),
                    'payment_method' => $this->payment_method,
                ]);

                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['id'],
                        'product_name' => $item['name'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                    ]);
                }

                // 3. Update Influencer Earnings
                if ($influencerId) {
                    $influencer = \App\Models\Influencer::find($influencerId);
                    $commission = ($finalTotal * $influencer->commission_rate) / 100;
                    $influencer->increment('earnings', $commission);
                }

                // 4. Update User Spend & Check Upgrade
                if (Auth::check()) {
                    $user = Auth::user();
                    $user->increment('lifetime_spend', $finalTotal);
                    $membershipService->checkUpgrade($user);
                }

                $cartService->clear();
                
                return $order->id;
            });

            return redirect()->route('flex', ['orderId' => $orderId]);
        } catch (\Exception $e) {
            $this->addError('checkout', 'Unable to place order. Please try again or contact support.');
            return;
        }
    }

    public function render()
    {
        return view('livewire.checkout', [
            'cartItems' => app(CartService::class)->get(),
            'total' => app(CartService::class)->total(),
        ]);
    }
}
