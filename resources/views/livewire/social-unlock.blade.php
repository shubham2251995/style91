<div class="mt-4 mb-6">
    @if(!$unlocked)
        <div class="bg-blue-600/10 border border-blue-600/20 rounded-xl p-4">
            <div class="flex justify-between items-center mb-3">
                <div>
                    <h4 class="font-bold text-blue-500 text-sm">SOCIAL UNLOCK</h4>
                    <p class="text-xs text-gray-400">Share to get $10 OFF</p>
                </div>
                <div class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">
                    SAVE $10
                </div>
            </div>
            
            <button wire:click="unlock" wire:loading.attr="disabled" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg text-sm hover:bg-blue-500 transition-colors flex justify-center items-center gap-2">
                <span wire:loading.remove>SHARE ON TWITTER</span>
                <span wire:loading>VERIFYING...</span>
                <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                </svg>
            </button>
        </div>
    @else
        <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4 flex items-center gap-3 animate-in fade-in zoom-in duration-300">
            <div class="bg-green-500 rounded-full p-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
            <div>
                <p class="font-bold text-green-500 text-sm">PRICE UNLOCKED</p>
                <p class="text-xs text-gray-400">Discount applied at checkout</p>
            </div>
        </div>
    @endif
</div>
