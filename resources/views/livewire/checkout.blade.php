<div class="min-h-screen bg-brand-black text-white p-6 pb-24">
    <h1 class="text-3xl font-bold tracking-tighter mb-8">SECURE <br> <span class="text-brand-accent">CHECKOUT</span></h1>

    <div class="space-y-4">
        
        <!-- Step 1: Shipping -->
        <div class="bg-white/5 rounded-2xl border border-white/10 overflow-hidden transition-all duration-300"
             :class="$wire.step === 1 ? 'opacity-100' : 'opacity-50'">
            <div class="p-6 border-b border-white/10 flex justify-between items-center">
                <h3 class="font-bold text-lg">01. SHIPPING</h3>
                @if($step > 1)
                    <button wire:click="$set('step', 1)" class="text-xs text-brand-accent hover:text-white">EDIT</button>
                @endif
            </div>
            
            @if($step === 1)
            <div class="p-6 space-y-4 animate-in slide-in-from-top-4 duration-300">
                <div>
                    <label class="block text-xs font-mono text-gray-400 mb-1">EMAIL</label>
                    <input wire:model="email" type="email" class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white focus:border-brand-accent focus:ring-0">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-mono text-gray-400 mb-1">FULL NAME</label>
                    <input wire:model="shipping.name" type="text" class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white focus:border-brand-accent focus:ring-0">
                    @error('shipping.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-mono text-gray-400 mb-1">ADDRESS</label>
                    <input wire:model="shipping.address" type="text" class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white focus:border-brand-accent focus:ring-0">
                    @error('shipping.address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-1">CITY</label>
                        <input wire:model="shipping.city" type="text" class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white focus:border-brand-accent focus:ring-0">
                        @error('shipping.city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-1">ZIP</label>
                        <input wire:model="shipping.zip" type="text" class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white focus:border-brand-accent focus:ring-0">
                        @error('shipping.zip') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button wire:click="nextStep" class="w-full bg-white text-black font-bold py-3 rounded-lg mt-4 hover:bg-brand-accent hover:text-white transition-colors">
                    CONTINUE TO PAYMENT
                </button>
            </div>
            @endif
        </div>

        <!-- Step 2: Payment -->
        <div class="bg-white/5 rounded-2xl border border-white/10 overflow-hidden transition-all duration-300"
             :class="$wire.step === 2 ? 'opacity-100' : 'opacity-50'">
            <div class="p-6 border-b border-white/10 flex justify-between items-center">
                <h3 class="font-bold text-lg">02. PAYMENT</h3>
                @if($step > 2)
                    <button wire:click="$set('step', 2)" class="text-xs text-brand-accent hover:text-white">EDIT</button>
                @endif
            </div>

            @if($step === 2)
            <div class="p-6 space-y-4 animate-in slide-in-from-top-4 duration-300">
                <div class="grid grid-cols-2 gap-4">
                    @foreach($activeGateways as $gateway)
                    <button wire:click="$set('payment_method', '{{ $gateway->slug }}')" 
                            class="p-4 rounded-xl border transition-all {{ $payment_method === $gateway->slug ? 'border-brand-accent bg-brand-accent/10' : 'border-white/10 hover:border-white/30' }}">
                        <span class="font-bold block mb-1">{{ $gateway->name }}</span>
                        <span class="text-xs text-gray-400">
                            {{ $gateway->slug === 'cod' ? 'Pay at door' : 'Secure Payment' }}
                        </span>
                    </button>
                    @endforeach
                </div>

                <button wire:click="nextStep" class="w-full bg-white text-black font-bold py-3 rounded-lg mt-4 hover:bg-brand-accent hover:text-white transition-colors">
                    REVIEW ORDER
                </button>
            </div>
            @endif
        </div>

        <!-- Step 3: Review -->
        <div class="bg-white/5 rounded-2xl border border-white/10 overflow-hidden transition-all duration-300"
             :class="$wire.step === 3 ? 'opacity-100' : 'opacity-50'">
            <div class="p-6 border-b border-white/10">
                <h3 class="font-bold text-lg">03. REVIEW</h3>
            </div>

            @if($step === 3)
            <div class="p-6 space-y-4 animate-in slide-in-from-top-4 duration-300">
                <!-- Order Summary -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <h3 class="font-mono text-sm text-gray-400 mb-4">ORDER SUMMARY</h3>
                    
                    @php
                        $cartService = app(\App\Services\CartService::class);
                        $subtotal = $cartService->getSubtotal();
                        $discount = 0;
                        if($appliedCoupon) {
                            $discount = $appliedCoupon->calculateDiscount($subtotal);
                        }
                        $giftCardDiscount = 0;
                        if($appliedGiftCard) {
                            $afterCoupon = $subtotal - $discount;
                            $giftCardDiscount = min($appliedGiftCard->balance, $afterCoupon);
                        }
                        $total = $subtotal - $discount - $giftCardDiscount;
                    @endphp

                    <div class="space-y-2 text-white">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-mono">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        @if($discount > 0)
                            <div class="flex justify-between text-green-400">
                                <span>Discount ({{ $appliedCoupon->code }})</span>
                                <span class="font-mono">-${{ number_format($discount, 2) }}</span>
                            </div>
                        @endif
                        @if($giftCardDiscount > 0)
                            <div class="flex justify-between text-yellow-400">
                                <span>Gift Card</span>
                                <span class="font-mono">-${{ number_format($giftCardDiscount, 2) }}</span>
                            </div>
                        @endif
                        <div class="border-t border-white/10 pt-2 flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span class="font-mono">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Coupon & Gift Card Section -->
                    <div class="mt-6 pt-6 border-t border-white/10">
                        <!-- Coupon Section -->
                        <h4 class="font-mono text-sm text-gray-400 mb-3">PROMO CODE</h4>
                        @if(!$appliedCoupon)
                            <div class="flex gap-2 mb-2">
                                <input 
                                    wire:model="couponCode" 
                                    type="text" 
                                    placeholder="Coupon code"
                                    class="flex-1 bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-500 text-sm"
                                >
                                <button 
                                    wire:click="applyCoupon"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50 cursor-not-allowed"
                                    class="bg-brand-accent text-brand-dark px-4 py-2 rounded-lg font-bold text-sm hover:bg-yellow-400 transition"
                                >
                                    <span wire:loading.remove>APPLY</span>
                                    <span wire:loading>APPLYING...</span>
                                </button>
                            </div>
                            @if($couponError)
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <button wire:click="placeOrder" class="w-full bg-brand-accent text-white font-bold py-4 rounded-xl hover:bg-blue-600 transition-colors shadow-[0_0_20px_rgba(59,130,246,0.5)]">
                    CONFIRM ORDER
                </button>
            </div>
            @endif
        </div>

    </div>
</div>
