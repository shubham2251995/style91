<div>
    <h2 class="text-3xl font-bold mb-8">Tiered Pricing</h2>

    <!-- Current Tiers -->
    <div class="bg-white/5 border border-white/10 rounded-2xl p-6 mb-8">
        <h3 class="font-bold text-xl mb-4">Active Price Tiers</h3>
        <div class="space-y-3">
            @foreach($tiers as $tier)
            <div class="flex justify-between items-center bg-white/5 border border-white/10 p-4 rounded-xl">
                <div>
                    <p class="font-bold text-lg">{{ $tier->min_quantity }}+ units</p>
                    <p class="text-sm text-gray-400">Minimum quantity</p>
                </div>
                <div class="text-center">
                    <p class="font-bold text-2xl text-green-400">{{ $tier->discount_percentage }}%</p>
                    <p class="text-xs text-gray-400">OFF</p>
                </div>
                <button wire:click="delete({{ $tier->id }})" class="text-red-500 hover:text-red-400 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Add New Tier -->
    <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
        <h3 class="font-bold text-xl mb-4">Add New Tier</h3>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-mono text-gray-400 mb-2">MIN QUANTITY</label>
                <input wire:model="min_quantity" type="number" min="1" class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white focus:border-brand-accent focus:ring-0" placeholder="e.g., 10">
                @error('min_quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-mono text-gray-400 mb-2">DISCOUNT %</label>
                <input wire:model="discount_percentage" type="number" step="0.01" min="0" max="100" class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white focus:border-brand-accent focus:ring-0" placeholder="e.g., 15">
                @error('discount_percentage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <button wire:click="addTier" class="w-full bg-brand-accent text-white font-bold py-3 rounded-xl hover:bg-blue-600 transition-colors">
            ADD TIER
        </button>
    </div>
</div>
