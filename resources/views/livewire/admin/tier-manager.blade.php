<div class="min-h-screen bg-black text-white p-6 pb-24">
    <div class="max-w-md mx-auto">
        <h1 class="text-3xl font-black tracking-tighter mb-8 text-brand-accent">MEMBERSHIP MANAGER</h1>

        <!-- Create Form -->
        <div class="bg-gray-900 rounded-xl p-6 border border-white/10 mb-8">
            <h2 class="text-xl font-bold mb-4">Add New Tier</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Tier Name</label>
                    <input wire:model="name" type="text" placeholder="e.g. Gold" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Threshold (₹)</label>
                        <input wire:model="threshold" type="number" placeholder="5000" class="w-full bg-black border border-white/20 rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Discount (%)</label>
                        <input wire:model="discount_percentage" type="number" placeholder="10" class="w-full bg-black border border-white/20 rounded p-2">
                    </div>
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Badge Color</label>
                    <input wire:model="color" type="color" class="w-full h-10 bg-black border border-white/20 rounded cursor-pointer">
                </div>
                <button wire:click="save" class="w-full bg-brand-accent text-black font-bold py-3 rounded hover:bg-white transition-colors">
                    CREATE TIER
                </button>
            </div>
        </div>

        <!-- List -->
        <div class="space-y-3">
            @foreach($tiers as $tier)
                <div class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 rounded-full shadow-lg" style="background-color: {{ $tier->color }}"></div>
                        <div>
                            <p class="font-bold">{{ $tier->name }}</p>
                            <p class="text-xs text-gray-500">₹{{ number_format($tier->threshold) }} • {{ $tier->discount_percentage }}% Off</p>
                        </div>
                    </div>
                    <button wire:click="delete({{ $tier->id }})" class="text-red-500 hover:text-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</div>
