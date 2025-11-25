<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Payment Method</h1>

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Payment Methods -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-bold mb-6">Select Payment Method</h2>

                    <div class="space-y-4">
                        @forelse($gateways as $gateway)
                            <div wire:click="selectGateway({{ $gateway->id }})" class="border-2 rounded-lg p-4 cursor-pointer {{ $selectedGatewayId == $gateway->id ? 'border-brand-accent bg-brand-accent/5' : 'border-gray-200 hover:border-gray-300' }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <!-- Gateway Icon -->
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                            @if($gateway->code === 'razorpay')
                                                <span class="text-blue-600 font-bold text-sm">Razorpay</span>
                                            @elseif($gateway->code === 'cashfree')
                                                <span class="text-green-600 font-bold text-sm">Cashfree</span>
                                            @elseif($gateway->code === 'cod')
                                                <span class="text-orange-600 font-bold text-sm">💵 COD</span>
                                            @endif
                                        </div>

                                        <div>
                                            <div class="font-bold">{{ $gateway->name }}</div>
                                            <div class="text-sm text-gray-600">{{ $gateway->description }}</div>
                                            
                                            @if($gateway->code === 'cod')
                                                @if(isset($gateway->rules['max_order_value']))
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        Available for orders up to ₹{{ number_format($gateway->rules['max_order_value'], 0) }}
                                                    </div>
                                                @endif
                                                @if(isset($gateway->rules['cod_charges']) && $gateway->rules['cod_charges'] > 0)
                                                    <div class="text-xs text-orange-600 mt-1">
                                                        + ₹{{ number_format($gateway->rules['cod_charges'], 0) }} COD charges
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                    @if($selectedGatewayId == $gateway->id)
                                        <svg class="w-6 h-6 text-brand-accent" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>

                                <!-- Payment Method Options -->
                                @if($selectedGatewayId == $gateway->id && $gateway->code !== 'cod')
                                    <div class="mt-4 pl-20 space-y-2">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" wire:model="paymentMethod" value="upi" class="mr-2">
                                            <span class="text-sm">UPI</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" wire:model="paymentMethod" value="card" class="mr-2">
                                            <span class="text-sm">Credit/Debit Card</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" wire:model="paymentMethod" value="netbanking" class="mr-2">
                                            <span class="text-sm">Net Banking</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" wire:model="paymentMethod" value="wallet" class="mr-2">
                                            <span class="text-sm">Wallets</span>
                                        </label>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <p>No payment methods available for this order</p>
                            </div>
                        @endforelse
                    </div>

                    @if($gateways->count() > 0)
                        <button 
                            wire:click="processPayment" 
                            wire:loading.attr="disabled"
                            class="w-full mt-6 px-6 py-4 bg-brand-dark text-white rounded-lg hover:bg-brand-accent hover:text-brand-dark font-bold text-lg disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span wire:loading.remove wire:target="processPayment">
                                @if($selectedGatewayId)
                                    @php $gateway = $gateways->find($selectedGatewayId); @endphp
                                    @if($gateway && $gateway->code === 'cod')
                                        Place Order
                                    @else
                                        Proceed to Pay ₹{{ number_format($order['total'] ?? 0, 2) }}
                                    @endif
                                @else
                                    Select Payment Method
                                @endif
                            </span>
                            <span wire:loading wire:target="processPayment">Processing...</span>
                        </button>
                    @endif

                    <!-- Security Badges -->
                    <div class="mt-6 flex items-center justify-center gap-4 text-xs text-gray-500">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Secure Payment</span>
                        </div>
                        <div>100% Safe & Secure</div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                    <h3 class="text-lg font-bold mb-4">Order Summary</h3>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($order['subtotal'] ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span>₹{{ number_format($order['shipping_cost'] ?? 0, 2) }}</span>
                        </div>
                        @if(isset($order['discount']) && $order['discount'] > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Discount</span>
                                <span>-₹{{ number_format($order['discount'], 2) }}</span>
                            </div>
                        @endif
                        
                        <!-- COD Charges -->
                        @if($selectedGatewayId)
                            @php 
                                $gateway = $gateways->find($selectedGatewayId);
                                $codCharges = 0;
                                if ($gateway && $gateway->code === 'cod' && isset($gateway->rules['cod_charges'])) {
                                    $codCharges = $gateway->rules['cod_charges'];
                                }
                            @endphp
                            @if($codCharges > 0)
                                <div class="flex justify-between text-orange-600">
                                    <span>COD Charges</span>
                                    <span>+₹{{ number_format($codCharges, 2) }}</span>
                                </div>
                            @endif
                        @endif

                        <div class="border-t pt-2 flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span>₹{{ number_format(($order['total'] ?? 0) + ($codCharges ?? 0), 2) }}</span>
                        </div>
                    </div>

                    <!-- Delivery Address -->
                    <div class="mt-6 pt-6 border-t">
                        <h4 class="font-bold text-sm mb-2">Deliver To</h4>
                        <div class="text-xs text-gray-600">
                            <div class="font-medium">{{ $order['shipping_name'] ?? '' }}</div>
                            <div>{{ $order['shipping_address'] ?? '' }}</div>
                            <div>{{ $order['shipping_city'] ?? '' }}, {{ $order['shipping_state'] ?? '' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Razorpay Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<!-- Cashfree Script -->
<script src="https://sdk.cashfree.com/js/ui/2.0.0/cashfree.sandbox.js"></script>

<script>
document.addEventListener('livewire:initialized', () => {
    // Razorpay Integration
    @this.on('initRazorpay', (data) => {
        var options = {
            key: data[0].key,
            amount: data[0].amount,
            currency: data[0].currency,
            name: data[0].name,
            description: data[0].description,
            order_id: data[0].order_id,
            prefill: data[0].prefill,
            handler: function(response) {
                @this.call('handlePaymentSuccess', {
                    payment_id: response.razorpay_payment_id,
                    order_id: data[0].order_id,
                    signature: response.razorpay_signature
                });
            },
            modal: {
                ondismiss: function() {
                    @this.call('handlePaymentFailure', {
                        order_id: data[0].order_id,
                        reason: 'Payment cancelled by user'
                    });
                }
            }
        };
        var rzp = new Razorpay(options);
        rzp.open();
    });

    // Cashfree Integration
    @this.on('initCashfree', (data) => {
        const cashfree = new Cashfree({
            mode: "sandbox" // Change to "production" in live
        });
        
        cashfree.checkout({
            paymentSessionId: data[0].orderId,
            returnUrl: "{{ route('payment.callback') }}"
        });
    });
});
</script>
