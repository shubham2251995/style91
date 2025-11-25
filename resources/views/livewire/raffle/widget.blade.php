@if($raffle)
<div class="mt-6 border-t border-gray-100 pt-6">
    <div class="bg-gradient-to-br from-purple-600/10 to-pink-600/10 border border-purple-600/20 rounded-2xl p-6 overflow-hidden relative">
        
        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 opacity-5" style="background-image: repeating-linear-gradient(45deg, #000 0, #000 1px, transparent 0, transparent 50%); background-size: 10px 10px;"></div>

        <div class="relative z-10">
            <!-- Header -->
            <div class="flex justify-between items-start mb-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></div>
                        <h4 class="font-bold text-black text-sm uppercase tracking-wider">RAFFLE LIVE</h4>
                    </div>
                    <p class="text-2xl font-bold text-black">{{ $raffle->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 font-mono">CLOSES IN</p>
                    <p class="text-lg font-bold text-black font-mono">{{ $raffle->closes_at->diffForHumans() }}</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="bg-black/5 rounded-xl p-3 border border-black/10">
                    <p class="text-xs text-gray-500 font-mono mb-1">ENTRIES</p>
                    <p class="text-2xl font-bold text-black">{{ $raffle->getCurrentEntriesCount() }}</p>
                </div>
                <div class="bg-black/5 rounded-xl p-3 border border-black/10">
                    <p class="text-xs text-gray-500 font-mono mb-1">WINNERS</p>
                    <p class="text-2xl font-bold text-black">{{ $raffle->winner_count }}</p>
                </div>
            </div>

            <!-- Action Button -->
            @if($hasEntered)
                <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4 flex items-center gap-3">
                    <div class="bg-green-500 rounded-full p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-green-700 text-sm">YOU'RE IN</p>
                        <p class="text-xs text-gray-500">Good luck! Winners announced after close.</p>
                    </div>
                </div>
            @else
                <button wire:click="enter" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-4 rounded-xl hover:from-purple-500 hover:to-pink-500 transition-all shadow-[0_0_20px_rgba(168,85,247,0.5)] hover:scale-[1.02]">
                    ENTER RAFFLE (FREE)
                </button>
            @endif

            <!-- Info Footer -->
            <p class="text-xs text-gray-500 mt-3 text-center">
                Winners selected randomly. You will be notified via email.
            </p>
        </div>
    </div>
</div>
@endif
