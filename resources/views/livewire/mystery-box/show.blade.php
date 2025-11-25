<div class="min-h-screen bg-brand-black text-white relative overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0">
        <img src="{{ $box->image_url }}" class="w-full h-full object-cover opacity-20 blur-xl">
    </div>

    <!-- Content -->
    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen p-6 text-center">
        
        @if(!$isOpening && !$wonProduct)
            <!-- Initial State -->
            <h1 class="text-4xl font-bold mb-2">{{ $box->name }}</h1>
            <p class="text-gray-400 mb-8 max-w-xs mx-auto">{{ $box->description }}</p>
            
            <div class="w-64 h-64 mb-8 relative animate-float">
                <img src="https://cdn-icons-png.flaticon.com/512/664/664468.png" class="w-full h-full object-contain filter drop-shadow-[0_0_30px_rgba(255,255,255,0.3)]">
            </div>

            <p class="text-3xl font-mono text-brand-accent font-bold mb-8">${{ $box->price }}</p>

            <button wire:click="openBox" class="w-full max-w-sm bg-white text-black font-bold py-4 rounded-xl hover:scale-105 transition-transform">
                OPEN BOX
            </button>
            
            <div class="mt-8 text-left w-full max-w-sm">
                <h3 class="text-sm font-bold text-gray-500 mb-4 uppercase tracking-wider">Possible Drops</h3>
                <div class="space-y-3">
                    @foreach($box->items as $item)
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-300">{{ $item->product->name }}</span>
                        <span class="font-mono text-gray-500">{{ $item->probability }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>

        @elseif($isOpening && !$wonProduct)
            <!-- Opening Animation State (Handled via JS/Alpine usually, but simulating here) -->
            <div class="animate-bounce w-64 h-64 mb-8">
                <img src="https://cdn-icons-png.flaticon.com/512/664/664468.png" class="w-full h-full object-contain">
            </div>
            <h2 class="text-2xl font-bold animate-pulse">OPENING...</h2>

        @elseif($wonProduct)
            <!-- Result State -->
            <div class="absolute inset-0 bg-black/90 flex flex-col items-center justify-center p-6 animate-fade-in">
                <p class="text-brand-accent font-mono mb-4">YOU UNLOCKED</p>
                
                <div class="w-64 h-64 mb-6 rounded-2xl overflow-hidden border-2 border-brand-accent shadow-[0_0_50px_rgba(59,130,246,0.5)]">
                    <img src="{{ $wonProduct->image_url }}" class="w-full h-full object-cover">
                </div>
                
                <h2 class="text-3xl font-bold mb-2">{{ $wonProduct->name }}</h2>
                <p class="text-gray-400 mb-8">Added to your collection</p>

                <div class="flex flex-col gap-3 w-full max-w-sm">
                    <a href="{{ route('product', $wonProduct->slug) }}" class="bg-brand-accent text-white font-bold py-4 rounded-xl">
                        VIEW ITEM
                    </a>
                    <button wire:click="resetBox" class="text-gray-400 hover:text-white py-2">
                        Open Another
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Back Button -->
    <a href="{{ route('mystery-box.index') }}" class="absolute top-6 left-6 p-2 bg-black/50 rounded-full backdrop-blur-md z-20">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>
