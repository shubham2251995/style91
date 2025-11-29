<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <div class="flex items-center {{ $step === 'address' ? 'text-brand-accent' : 'text-green-600' }}">
                        <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center font-bold {{ $step === 'address' ? 'border-brand-accent bg-brand-accent text-white' : 'border-green-600 bg-green-600 text-white' }}">
                            @if($step !== 'address')✓@else1@endif
                        </div>
                        <span class="ml-2 font-medium hidden sm:inline">Address</span>
                    </div>
                    <div class="w-16 h-1 {{ $step !== 'address' ? 'bg-green-600' : 'bg-gray-300' }} mx-2"></div>
                    <div class="flex items-center {{ $step === 'shipping' ? 'text-brand-accent' : ($step === 'review' ? 'text-green-600' : 'text-gray-400') }}">
                        <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center font-bold {{ $step === 'shipping' ? 'border-brand-accent bg-brand-accent text-white' : ($step === 'review' ? 'border-green-600 bg-green-600 text-white' : 'border-gray-300') }}">
                            @if($step === 'review')✓@else2@endif
                        </div>
                        <span class="ml-2 font-medium hidden sm:inline">Shipping</span>
                    </div>
                    <div class="w-16 h-1 {{ $step === 'review' ? 'bg-green-600' : 'bg-gray-300' }} mx-2"></div>
                    <div class="flex items-center {{ $step === 'review' ? 'text-brand-accent' : 'text-gray-400' }}">
                        <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center font-bold {{ $step === 'review' ? 'border-brand-accent bg-brand-accent text-white' : 'border-gray-300' }}">
                            3
                        </div>
                        <span class="ml-2 font-medium hidden sm:inline">Review</span>
                    </div>
                </div>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Address Step -->
                @if($step === 'address')
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-2xl font-bold mb-6">Delivery Address</h2>

                        <!-- Saved Addresses -->
                        @if(Auth::check() && $addresses->count() > 0)
                            <div class="space-y-3 mb-6">
                                @foreach($addresses as $address)
                                    <div wire:click="selectAddress({{ $address->id }})" class="border-2 rounded-lg p-4 cursor-pointer {{ $selected AddressId == $address->id ? 'border-brand-accent bg-brand-accent/5' : 'border-gray-200 hover:border-gray-300' }}">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <div class="font-bold">{{ $address->full_name }}</div>
                                                <div class="text-sm text-gray-600">{{ $address->phone }}</div>
                                                <div class="text-sm text-gray-600 mt-1">{{ $address->full_address }}</div>
                                            </div>
                                            @if($address->is_default)
                                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Default</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button wire:click="$toggle('showAddressForm')" class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-brand-accent hover:text-brand-accent font-medium">
                                + Add New Address
                            </button>
                        @endif

                        <!-- Address Form -->
                        @if(Auth::guest() || $showAddressForm)
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                        <input type="text" wire:model="fullName" class="w-full border-gray-300 rounded-lg">
                                        @error('fullName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                                        <input type="tel" wire:model="phone" class="w-full border-gray-300 rounded-lg">
                                        @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 1 *</label>
                                    <input type="text" wire:model="addressLine1" class="w-full border-gray-300 rounded-lg">
                                    @error('addressLine1') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 2</label>
                                    <input type="text" wire:model="addressLine2" class="w-full border-gray-300 rounded-lg">
                                </div>

                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                        <input type="text" wire:model="city" class="w-full border-gray-300 rounded-lg">
                                        @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                                        <input type="text" wire:model="state" class="w-full border-gray-300 rounded-lg">
                                        @error('state') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Postcode *</label>
                                        <input type="text" wire:model="postcode" class="w-full border-gray-300 rounded-lg">
                                        @error('postcode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                @if(Auth::check() && $showAddressForm)
                                    <div class="flex items-center gap-4">
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model="isDefault" class="rounded">
                                            <span class="ml-2 text-sm">Set as default</span>
                                        </label>
                                        <input type="text" wire:model="label" placeholder="Label (e.g., Home)" class="flex-1 border-gray-300 rounded-lg text-sm">
                                    </div>

                                    <button wire:click="saveAddress" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold">
                                        Save Address
                                    </button>
                                @endif
                            </div>
                        @endif

                        <button wire:click="continueToShipping" class="w-full mt-6 px-6 py-3 bg-brand-dark text-white rounded-lg hover:bg-brand-accent hover:text-brand-dark font-bold">
                            Continue to Shipping
                        </button>
                    </div>
                @endif

                <!-- Shipping Step -->
                @if($step === 'shipping')
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-2xl font-bold mb-6">Select Shipping Method</h2>

                        <div class="space-y-3">
                            @foreach($shippingMethods as $method)
                                <div wire:click="selectShippingMethod({{ $method->id }})" class="border-2 rounded-lg p-4 cursor-pointer {{ $selectedShippingMethodId == $method->id ? 'border-brand-accent bg-brand-accent/5' : 'border-gray-200 hover:border-gray-300' }}">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <div class="font-bold">{{ $method->name }}</div>
                                            <div class="text-sm text-gray-600">{{ $method->description }}</div>
                                            <div class="text-sm text-gray-500 mt-1">Delivery: {{ $method->getEstimatedDelivery() }}</div>
                                        </div>
                                        <div class="text-lg font-bold">
                                            @if($method->cost > 0)
                                                ₹{{ number_format($method->cost, 2) }}
                                            @else
                                                FREE
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex gap-4 mt-6">
                            <button wire:click="$set('step', 'address')" class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-gray-400 font-bold">
                                Back
                            </button>
                            <button wire:click="continueToReview" class="flex-1 px-6 py-3 bg-brand-dark text-white rounded-lg hover:bg-brand-accent hover:text-brand-dark font-bold">
                                Continue to Review
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Review Step -->
                @if($step === 'review')
                    <div class="space-y-6">
                        <!-- Address Summary -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-lg">Delivery Address</h3>
                                <button wire:click="$set('step', 'address')" class="text-blue-600 text-sm hover:text-blue-800">Change</button>
                            </div>
                            <div class="text-gray-700">
                                <div class="font-medium">{{ $fullName }}</div>
                                <div class="text-sm">{{ $phone }}</div>
                                <div class="text-sm mt-1">{{ $addressLine1 }}@if($addressLine2), {{ $addressLine2 }}@endif</div>
                                <div class="text-sm">{{ $city }}, {{ $state }} {{ $postcode }}</div>
                            </div>
                        </div>

                        <!-- Shipping Summary -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-lg">Shipping Method</h3>
                                <button wire:click="$set('step', 'shipping')" class="text-blue-600 text-sm hover:text-blue-800">Change</button>
                            </div>
                            <div class="text-gray-700">
                                @if($selectedShippingMethodId)
                                    @php $method = $shippingMethods->find($selectedShippingMethodId); @endphp
                                    <div class="font-medium">{{ $method->name }}</div>
                                    <div class="text-sm">₹{{ number_format($shippingCost, 2) }}</div>
                                @endif
                            </div>
                        </div>

                        <button wire:click="proceedToPayment" class="w-full px-6 py-3 bg-brand-dark text-white rounded-lg hover:bg-brand-accent hover:text-brand-dark font-bold text-lg">
                            Proceed to Payment
                        </button>
                    </div>
                @endif
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                    <h3 class="text-lg font-bold mb-4">Order Summary</h3>

                    <!-- Cart Items -->
                    <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                        @forelse($cartItems as $item)
                            <div class="flex gap-3">
                                <div class="w-16 h-16 bg-gray-100 rounded"></div>
                                <div class="flex-1">
                                    <div class="text-sm font-medium">{{ $item['name'] ?? 'Product' }}</div>
                                    <div class="text-xs text-gray-600">Qty: {{ $item['quantity'] ?? 1 }}</div>
                                </div>
                                <div class="text-sm font-bold">₹{{ number_format($item['price'] ?? 0, 2) }}</div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No items in cart</p>
                        @endforelse
                    </div>

                    <!-- Loyalty Points -->
                    @auth
                        @if(Auth::user()->loyalty_points > 0)
                            <div class="mb-4 p-3 bg-brand-accent/10 rounded-lg border border-brand-accent/20">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model.live="usePoints" class="rounded text-brand-accent focus:ring-brand-accent">
                                    <span class="text-sm font-bold text-brand-black">Redeem {{ Auth::user()->loyalty_points }} Points</span>
                                </label>
                                @if($usePoints)
                                    <div class="mt-2 text-xs text-gray-600 flex justify-between">
                                        <span>Redeeming {{ $pointsToRedeem }} pts</span>
                                        <span class="font-bold text-green-600">-₹{{ number_format($pointsDiscount, 2) }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endauth

                    <!-- Coupon -->
                    <div class="mb-4">
                        <div class="flex gap-2">
                            <input type="text" wire:model="couponCode" placeholder="Coupon code" class="flex-1 border-gray-300 rounded-lg text-sm">
                            <button wire:click="applyCoupon" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm font-medium">
                                Apply
                            </button>
                        </div>
                    </div>

                    <!-- Totals -->
                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($cartTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>Shipping</span>
                            <span>₹{{ number_format($shippingCost, 2) }}</span>
                        </div>
                        @if($discount > 0)
                            <div class="flex justify-between text-sm text-green-600">
                                <span>Discount</span>
                                <span>-₹{{ number_format($discount, 2) }}</span>
                            </div>
                        @endif
                        @if($pointsDiscount > 0)
                            <div class="flex justify-between text-sm text-brand-accent font-bold">
                                <span>Points Redeemed</span>
                                <span>-₹{{ number_format($pointsDiscount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-lg font-bold border-t pt-2">
                            <span>Total</span>
                            <span>₹{{ number_format($finalTotal, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
