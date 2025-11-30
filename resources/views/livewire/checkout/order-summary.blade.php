{{-- Vibrant Order Summary Component --}}
<div class="bg-gradient-to-br from-black via-gray-900 to-black border-2 border-brand-500/30 rounded-2xl overflow-hidden sticky top-24 shadow-glow-yellow">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-brand-500 to-accent-500 px-6 py-4">
        <h2 class="text-xl font-black text-black flex items-center gap-2">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
            </svg>
            Order Summary
        </h2>
    </div>

    {{-- Cart Items --}}
    <div class="p-6 border-b border-brand-500/20">
        <div class="space-y-4 max-h-64 overflow-y-auto scrollbar-hide">
            @foreach($items as $item)
            <div class="flex gap-3 group">
                {{-- Product Image --}}
                <div class="w-20 h-20 bg-white/5 rounded-lg overflow-hidden flex-shrink-0 border border-white/10 group-hover:border-brand-500/50 transition">
                    <img src="{{ $item['image'] ?? '/images/placeholder.jpg' }}" 
                         alt="{{ $item['name'] }}"
                         class="w-full h-full object-cover">
                </div>

                {{-- Product Details --}}
                <div class="flex-1 min-w-0">
                    <h3 class="text-white font-bold text-sm line-clamp-1 mb-1">{{ $item['name'] }}</h3>
                    <p class="text-gray-400 text-xs mb-2">Qty: {{ $item['quantity'] }}</p>
                    <div class="flex items-center gap-2">
                        <span class="text-brand-500 font-bold">₹{{ number_format($item['price'] * $item['quantity']) }}</span>
                        @if($item['original_price'] && $item['original_price'] > $item['price'])
                        <span class="text-gray-500 text-xs line-through">₹{{ number_format($item['original_price'] * $item['quantity']) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Price Breakdown --}}
    <div class="p-6 space-y-4">
        {{-- Subtotal --}}
        <div class="flex items-center justify-between text-gray-300">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                </svg>
                Subtotal
            </span>
            <span class="font-bold text-white">₹{{ number_format($subtotal) }}</span>
        </div>

        {{-- Discount --}}
        @if($discount > 0)
        <div class="flex items-center justify-between text-green-400">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"></path>
                </svg>
                Discount
                @if($couponCode)
                <span class="text-xs bg-green-500/20 px-2 py-0.5 rounded-full border border-green-500/30">{{ $couponCode }}</span>
                @endif
            </span>
            <span class="font-bold">-₹{{ number_format($discount) }}</span>
        </div>
        @endif

        {{-- Shipping --}}
        <div class="flex items-center justify-between {{ $shipping === 0 ? 'text-green-400' : 'text-gray-300' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                </svg>
                Shipping
                @if($shipping === 0)
                <span class="text-xs">🎉 FREE</span>
                @endif
            </span>
            <span class="font-bold {{ $shipping === 0 ? '' : 'text-white' }}">
                {{ $shipping === 0 ? 'FREE' : '₹' . number_format($shipping) }}
            </span>
        </div>

        {{-- Tax/GST --}}
        @if($tax > 0)
        <div class="flex items-center justify-between text-gray-300">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
                Tax (GST)
            </span>
            <span class="font-bold text-white">₹{{ number_format($tax) }}</span>
        </div>
        @endif

        {{-- Total --}}
        <div class="pt-4 border-t-2 border-brand-500/30">
            <div class="flex items-center justify-between">
                <span class="text-gray-300 font-bold uppercase tracking-wider text-sm">Total</span>
                <div class="text-right">
                    <div class="text-3xl font-black text-gradient-vibrant">
                        ₹{{ number_format($total) }}
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Incl. of all taxes</p>
                </div>
            </div>
        </div>

        {{-- Savings Badge --}}
        @if($totalSavings > 0)
        <div class="bg-gradient-to-r from-green-600/20 to-emerald-600/20 border border-green-500/30 rounded-xl p-3">
            <div class="flex items-center gap-2 text-green-400">
                <svg class="w-5 h-5 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="font-bold">You're saving ₹{{ number_format($totalSavings) }}! 🎉</p>
                    <p class="text-xs text-green-300">Great choice!</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Trust Badges --}}
    <div class="px-6 pb-6">
        <div class="grid grid-cols-2 gap-3 text-center">
            <div class="bg-white/5 border border-white/10 rounded-lg p-3">
                <svg class="w-6 h-6 text-green-400 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-xs font-bold text-white">Secure</p>
                <p class="text-[10px] text-gray-400">100% Safe</p>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-lg p-3">
                <svg class="w-6 h-6 text-blue-400 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-xs font-bold text-white">Easy Returns</p>
                <p class="text-[10px] text-gray-400">7 Days</p>
            </div>
        </div>
    </div>
</div>
