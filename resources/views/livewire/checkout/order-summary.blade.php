<div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
    <h3 class="font-black text-xl text-brand-black uppercase tracking-tight mb-6">Order Summary</h3>
    
    <!-- Cart Items -->
    @if(count($cart) > 0)
        <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
            @foreach($cart as $item)
                <div class="flex gap-3">
                    <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-sm text-gray-900 truncate">{{ $item['name'] }}</h4>
                        @if(isset($item['options']) && !empty($item['options']))
                            <p class="text-xs text-gray-500">
                                @foreach($item['options'] as $key => $value)
                                    {{ $key }}: {{ $value }}@if(!$loop->last), @endif
                                @endforeach
                            </p>
                        @endif
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-xs text-gray-500">Qty: {{ $item['quantity'] }}</span>
                            <span class="text-sm font-bold text-gray-900">₹{{ number_format($item['price'] * $item['quantity']) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-200 my-4"></div>

        <!-- Price Breakdown -->
        <div class="space-y-3">
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Subtotal</span>
                <span class="font-medium text-gray-900">₹{{ number_format($subtotal) }}</span>
            </div>

            @if($discount > 0)
                <div class="flex justify-between text-sm text-green-600">
                    <span>Discount</span>
                    <span class="font-medium">-₹{{ number_format($discount) }}</span>
                </div>
            @endif

            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Shipping</span>
                @if($shipping == 0)
                    <span class="font-medium text-green-600">FREE</span>
                @else
                    <span class="font-medium text-gray-900">₹{{ number_format($shipping) }}</span>
                @endif
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Tax (GST 18%)</span>
                <span class="font-medium text-gray-900">₹{{ number_format($tax) }}</span>
            </div>
        </div>

        <!-- Total -->
        <div class="border-t border-gray-200 mt-4 pt-4">
            <div class="flex justify-between items-center">
                <span class="text-lg font-black text-gray-900 uppercase">Total</span>
                <span class="text-2xl font-black text-brand-accent">₹{{ number_format($total) }}</span>
            </div>
        </div>

        <!-- Free Shipping Progress -->
        @if($shipping > 0 && $subtotal < 999)
            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-xs font-medium text-yellow-800 mb-2">
                    Add ₹{{ number_format(999 - $subtotal) }} more for FREE shipping!
                </p>
                <div class="w-full bg-yellow-200 rounded-full h-2 overflow-hidden">
                    <div class="bg-yellow-500 h-full rounded-full transition-all duration-300" style="width: {{ min(($subtotal / 999) * 100, 100) }}%"></div>
                </div>
            </div>
        @elseif($shipping == 0)
            <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-600">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
                <p class="text-xs font-medium text-green-800">You've unlocked FREE shipping!</p>
            </div>
        @endif

    @else
        <div class="text-center py-8">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-300 mb-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 5.018a7.963 7.963 0 01-6.534 9.347A7.967 7.967 0 0118 17.75V8.25c2.761 0 5 2.239 5 5z" />
            </svg>
            <p class="text-gray-500 text-sm">Your cart is empty</p>
        </div>
    @endif
</div>
