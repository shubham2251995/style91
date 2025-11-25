<div class="min-h-screen bg-brand-black flex items-center justify-center p-6">
    <div class="max-w-md w-full relative group">
        
        <!-- Glow Effect -->
        <div class="absolute -inset-1 bg-gradient-to-r from-brand-accent to-purple-600 rounded-2xl blur opacity-75 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
        
        <!-- Card Container -->
        <div class="relative bg-black border border-white/10 rounded-xl p-8 overflow-hidden">
            
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>

            <!-- Header -->
            <div class="relative z-10 flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-display font-bold tracking-tighter text-white">VERIFIED <br> <span class="text-brand-accent">COP</span></h1>
                    <p class="text-xs font-mono text-gray-400 mt-1">ORDER #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="bg-white/10 p-2 rounded-lg">
                    <!-- QR Code Placeholder -->
                    <div class="w-12 h-12 bg-white flex items-center justify-center">
                        <div class="w-10 h-10 bg-black"></div>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="relative z-10 space-y-4 mb-8">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-800 rounded-lg overflow-hidden">
                        <!-- Placeholder for item image if we had it in order_items, or fetch from product -->
                        <div class="w-full h-full bg-brand-accent/20"></div>
                    </div>
                    <div>
                        <p class="font-bold text-white">{{ $item->product_name }}</p>
                        <p class="text-xs text-gray-400 font-mono">QTY: {{ $item->quantity }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Footer -->
            <div class="relative z-10 border-t border-white/10 pt-6 flex justify-between items-end">
                <div>
                    <p class="text-xs text-gray-500 font-mono mb-1">TOTAL VALUE</p>
                    <p class="text-2xl font-bold text-white">${{ number_format($order->total, 2) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 font-mono mb-1">DATE</p>
                    <p class="text-sm font-bold text-white">{{ $order->created_at->format('d.m.Y') }}</p>
                </div>
            </div>

            <!-- Watermark -->
            <div class="absolute bottom-4 right-4 opacity-5 pointer-events-none">
                <h1 class="text-6xl font-bold tracking-tighter">SINGULARITY</h1>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-8 flex gap-4">
            <a href="{{ route('home') }}" class="flex-1 bg-white/5 hover:bg-white/10 text-white font-bold py-3 rounded-xl text-center transition-colors border border-white/10">
                RETURN HOME
            </a>
            <button class="flex-1 bg-brand-accent text-white font-bold py-3 rounded-xl hover:bg-blue-600 transition-colors shadow-[0_0_20px_rgba(59,130,246,0.5)]">
                SHARE FLEX
            </button>
        </div>
    </div>
</div>
