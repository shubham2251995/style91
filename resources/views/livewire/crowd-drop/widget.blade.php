@if($drop)
<div class="bg-gradient-to-br from-purple-900/20 to-blue-900/20 border border-purple-500/30 rounded-2xl p-6 mb-8 relative overflow-hidden">
    <!-- Background Pulse -->
    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/20 rounded-full blur-3xl animate-pulse"></div>

    <div class="relative z-10">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-xl font-bold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-purple-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                    CROWD DROP
                </h3>
                <p class="text-sm text-gray-400">Price drops as more people join!</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">CURRENT PRICE</p>
                <p class="text-3xl font-bold text-purple-400">${{ number_format($drop->current_price, 2) }}</p>
                <p class="text-xs text-gray-500 line-through">${{ number_format($drop->start_price, 2) }}</p>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="w-full bg-black/30 rounded-full h-2 mb-4 overflow-hidden">
            @php
                $progress = (($drop->start_price - $drop->current_price) / ($drop->start_price - $drop->min_price)) * 100;
            @endphp
            <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-full transition-all duration-1000" style="width: {{ $progress }}%"></div>
        </div>

        <div class="flex justify-between items-center mb-6 text-xs font-mono text-gray-400">
            <span>{{ $drop->participants_count }} JOINED</span>
            <span>NEXT DROP: -${{ $drop->drop_amount }}</span>
        </div>

        @if($hasJoined)
            <button disabled class="w-full bg-green-500/20 text-green-400 border border-green-500/50 font-bold py-3 rounded-xl flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                YOU'RE IN!
            </button>
            <p class="text-center text-xs text-gray-500 mt-2">You've locked in this price (or lower).</p>
        @else
            <button wire:click="joinDrop" class="w-full bg-purple-600 text-white font-bold py-3 rounded-xl hover:bg-purple-500 transition-colors shadow-[0_0_20px_rgba(147,51,234,0.3)] hover:shadow-[0_0_30px_rgba(147,51,234,0.5)]">
                JOIN THE DROP (-${{ $drop->drop_amount }})
            </button>
        @endif
    </div>
</div>
@endif
