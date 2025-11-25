<div class="min-h-screen bg-brand-black text-white p-6 pb-24 flex items-center justify-center">
    <div class="w-full max-w-2xl">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold tracking-tighter mb-2">REQUEST <span class="text-brand-accent">QUOTE</span></h1>
            <p class="text-gray-400">For large orders (50+ items), get a custom price from The Syndicate.</p>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-2xl p-8 backdrop-blur-xl">
            <div class="mb-8">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Order Summary</h3>
                <div class="space-y-3 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                    @foreach($items as $item)
                    <div class="flex justify-between items-center text-sm border-b border-white/5 pb-2">
                        <div>
                            <span class="font-bold">{{ $item['name'] }}</span>
                            <span class="text-gray-500 ml-2">x{{ $item['quantity'] }}</span>
                        </div>
                        <span class="font-mono text-gray-400">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t border-white/10 flex justify-between items-center">
                    <span class="text-gray-400">Total Items</span>
                    <span class="font-bold text-xl">{{ $totalItems }}</span>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Additional Notes</label>
                <textarea wire:model="notes" rows="4" placeholder="Any specific requirements, deadlines, or shipping instructions?" 
                          class="w-full bg-black/50 border border-white/10 rounded-xl p-4 text-white placeholder-gray-600 focus:outline-none focus:border-brand-accent transition-colors"></textarea>
            </div>

            <button wire:click="submitQuote" class="w-full bg-brand-accent text-white font-bold py-4 rounded-xl hover:scale-[1.02] transition-transform shadow-[0_0_30px_rgba(59,130,246,0.3)]">
                SUBMIT REQUEST
            </button>
            
            <p class="text-center text-xs text-gray-500 mt-4">
                By submitting, you agree to our B2B terms of service. Response time: < 24 hours.
            </p>
        </div>
    </div>
</div>
