<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-brand-dark">My Gift Cards</h2>
        <a href="{{ route('gift-cards.purchase') }}" class="bg-brand-accent text-brand-dark px-4 py-2 rounded-lg font-bold text-sm hover:bg-yellow-400 transition">
            + BUY GIFT CARD
        </a>
    </div>

    @if($giftCards->count() > 0)
        <div class="grid md:grid-cols-2 gap-4">
            @foreach($giftCards as $card)
            <div class="bg-gradient-to-br from-{{ $card->status === 'active' ? 'brand-accent' : 'gray-400' }} to-{{ $card->status === 'active' ? 'yellow-400' : 'gray-500' }} rounded-xl p-6 text-brand-dark relative overflow-hidden">
                <!-- Status Badge -->
                <div class="absolute top-4 right-4">
                    @if($card->status === 'active')
                        <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">ACTIVE</span>
                    @elseif($card->status === 'used')
                        <span class="px-3 py-1 bg-gray-600 text-white text-xs font-bold rounded-full">USED</span>
                    @elseif($card->status === 'expired')
                        <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full">EXPIRED</span>
                    @elseif($card->status === 'partially_used')
                        <span class="px-3 py-1 bg-blue-500 text-white text-xs font-bold rounded-full">PARTIAL</span>
                    @else
                        <span class="px-3 py-1 bg-gray-700 text-white text-xs font-bold rounded-full">INACTIVE</span>
                    @endif
                </div>

                <!-- Card Details -->
                <div class="mb-4">
                    <p class="text-sm font-bold opacity-80 mb-1">GIFT CARD CODE</p>
                    <p class="text-2xl font-black tracking-wider">{{ $card->code }}</p>
                </div>

                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-bold">Balance:</span>
                        <span class="text-2xl font-black">${{ number_format($card->balance, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs opacity-80">
                        <span>Original Value:</span>
                        <span>${{ number_format($card->initial_value, 2) }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs">
                    @if($card->recipient_email)
                        <div>
                            <p class="opacity-80">Sent to:</p>
                            <p class="font-bold truncate">{{ $card->recipient_email }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="opacity-80">Expires:</p>
                        <p class="font-bold">{{ $card->expires_at->format('M d, Y') }}</p>
                    </div>
                </div>

                @if($card->message)
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <p class="text-xs opacity-80 mb-1">Message:</p>
                        <p class="text-sm italic">"{{ $card->message }}"</p>
                    </div>
                @endif

                <!-- Copy Code Button -->
                @if($card->status === 'active' || $card->status === 'partially_used')
                    <button 
                        x-data
                        @click="navigator.clipboard.writeText('{{ $card->code }}'); $dispatch('code-copied')"
                        class="mt-4 w-full bg-brand-dark text-brand-accent py-2 rounded-lg font-bold text-sm hover:bg-gray-800 transition"
                    >
                        📋 COPY CODE
                    </button>
                @endif
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16 bg-gray-50 rounded-lg">
            <div class="mb-4 text-6xl">🎁</div>
            <p class="text-gray-500 mb-6">You haven't purchased any gift cards yet</p>
            <a href="{{ route('gift-cards.purchase') }}" class="inline-block bg-brand-accent text-brand-dark px-8 py-3 rounded-xl font-bold hover:bg-yellow-400 transition">
                BUY YOUR FIRST GIFT CARD
            </a>
        </div>
    @endif

    <!-- Toast notification for copy -->
    <div 
        x-data="{ show: false }"
        @code-copied.window="show = true; setTimeout(() => show = false, 2000)"
        x-show="show"
        x-transition
        class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50"
        style="display: none;"
    >
        ✓ Code copied to clipboard!
    </div>
</div>
