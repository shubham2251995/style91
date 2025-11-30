<div x-data="{ added: @entangle('added') }" 
     @reset-button.window="if ($event.detail.id == {{ $productId }}) { setTimeout(() => added = false, 2000) }">
    <button 
        wire:click="addToCart"
        @click="$dispatch('open-cart')"
        :disabled="added"
        class="w-full bg-brand-dark text-white font-bold py-2 rounded-lg hover:bg-opacity-90 transition text-sm disabled:bg-green-500"
    >
        <span x-show="!added">ADD TO CART</span>
        <span x-show="added" class="flex items-center justify-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            ADDED
        </span>
    </button>
</div>
