<div class="min-h-screen bg-brand-black text-white p-6 pb-24">
    <h1 class="text-3xl font-bold tracking-tighter mb-8">YOUR <br> <span class="text-brand-accent">STASH</span></h1>

    @if(count($this->cartItems) > 0)
        <div class="space-y-4">
            @foreach($this->cartItems as $item)
            <div class="bg-white/5 rounded-2xl p-4 flex gap-4 items-center backdrop-blur-sm border border-white/10">
                <img src="{{ $item['image_url'] }}" class="w-20 h-20 object-cover rounded-xl bg-gray-800">
                
                <div class="flex-1">
                    <h3 class="font-bold text-lg leading-tight">{{ $item['name'] }}</h3>
                    <p class="text-brand-accent font-mono text-sm">${{ $item['price'] }}</p>
                </div>

                <div class="flex flex-col items-end gap-2">
                    <button wire:click="remove({{ $item['id'] }})" wire:loading.attr="disabled" class="text-gray-500 hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    <div class="flex items-center bg-black/50 rounded-xl p-1.5 border border-white/10 relative">
                        <!-- Loading Overlay for Item -->
                        <div wire:loading wire:target="increment({{ $item['id'] }}), decrement({{ $item['id'] }})" class="absolute inset-0 bg-black/80 rounded-xl flex items-center justify-center z-10">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                        <button wire:click="decrement({{ $item['id'] }})" wire:loading.attr="disabled" class="p-2 hover:text-brand-accent transition-colors w-8 h-8 flex items-center justify-center">-</button>
                        <span class="mx-2 font-mono text-sm font-bold w-4 text-center">{{ $item['quantity'] }}</span>
                        <button wire:click="increment({{ $item['id'] }})" wire:loading.attr="disabled" class="p-2 hover:text-brand-accent transition-colors w-8 h-8 flex items-center justify-center">+</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Summary -->
        <div class="fixed bottom-20 left-0 w-full pointer-events-none z-40">
            <div class="max-w-md mx-auto px-6 pointer-events-auto">
                <div class="bg-brand-white text-brand-black rounded-2xl p-6 shadow-[0_0_30px_rgba(0,0,0,0.1)] border border-gray-100">
                
                @if($this->tieredPricingActive && $this->discount > 0)
                    <div class="space-y-2 mb-4 pb-4 border-b border-black/10">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                <div class="border-t border-white/10 pt-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-400">Subtotal</span>
                        <span class="font-mono">${{ number_format($this->total, 2) }}</span>
                    </div>
                    
                    @if($this->discount > 0)
                    <div class="flex justify-between items-center mb-2 text-brand-accent">
                        <span class="text-xs uppercase tracking-wider">Bulk Discount</span>
                        <span class="font-mono">-${{ number_format($this->discount, 2) }}</span>
                    </div>
                    @endif

                    <div class="flex justify-between items-center mb-8 text-xl font-bold">
                        <span>Total</span>
                        <span class="font-mono">${{ number_format($this->tieredTotal, 2) }}</span>
                    </div>

                    <a href="{{ route('checkout') }}" class="block w-full bg-white text-black text-center font-bold py-4 rounded-xl hover:scale-[1.02] transition-transform mb-3">
                        CHECKOUT
                    </a>
                    
                    @if($this->cartCount >= 50 && $this->quoteEngineActive)
                        <a href="{{ route('quote.request') }}" class="block w-full bg-brand-accent/10 text-brand-accent border border-brand-accent/50 text-center font-bold py-4 rounded-xl hover:bg-brand-accent/20 transition-colors">
                            REQUEST CUSTOM QUOTE
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center h-[60vh] text-center">
            <div class="bg-white/5 p-8 rounded-full mb-6 animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 5c.07.277-.029.561-.225.761A1.125 1.125 0 0119.66 15H4.34a1.125 1.125 0 01-.894-1.732l1.263-5a1.125 1.125 0 011.092-.852H18.57c.47 0 .91.247 1.092.852z" />
                </svg>
            </div>
            <h3 class="text-2xl font-black mb-2 tracking-tight">YOUR STASH IS EMPTY</h3>
            <p class="text-gray-400 mb-8 max-w-xs mx-auto">The singularity awaits. Don't get left behind.</p>
            <a href="{{ route('home') }}" class="bg-brand-accent text-brand-black px-10 py-4 rounded-xl font-bold hover:scale-105 transition-transform shadow-[0_0_20px_rgba(255,255,255,0.2)]">
                EXPLORE DROPS
            </a>
        </div>
    @endif
</div>
