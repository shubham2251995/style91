<div class="min-h-screen bg-gray-900 text-white pt-20 pb-24">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-3xl font-black mb-8">REMIX STUDIO</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Canvas Area -->
            <div class="md:col-span-2 bg-black rounded-xl border border-white/10 p-4 relative aspect-square" id="canvas-container">
                @if($product)
                    <img src="{{ $product->image_url }}" class="w-full h-full object-contain pointer-events-none select-none">
                @else
                    <div class="flex items-center justify-center h-full text-gray-500">No Product Selected</div>
                @endif
                
                <!-- Draggable Stickers Container (JS managed) -->
                <div id="stickers-layer" class="absolute inset-0 overflow-hidden"></div>
            </div>

            <!-- Tools -->
            <div class="space-y-6">
                <div class="bg-white/5 p-6 rounded-xl">
                    <h3 class="font-bold mb-4 text-gray-400 uppercase text-xs">Sticker Pack</h3>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($stickers as $sticker)
                            <button 
                                onclick="addSticker('{{ $sticker }}')"
                                class="aspect-square bg-black/50 rounded-lg flex items-center justify-center text-2xl hover:bg-white/10 transition-colors"
                            >
                                {{ $sticker }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white/5 p-6 rounded-xl">
                    <button onclick="downloadRemix()" class="w-full bg-brand-accent text-white font-bold py-3 rounded-lg hover:bg-blue-600 transition-colors mb-4">
                        Download Remix
                    </button>
                    <p class="text-xs text-gray-500 text-center">Share your creation on socials to unlock exclusive rewards.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addSticker(emoji) {
            const layer = document.getElementById('stickers-layer');
            const el = document.createElement('div');
            el.innerText = emoji;
            el.className = 'absolute text-4xl cursor-move select-none';
            el.style.left = '50%';
            el.style.top = '50%';
            el.style.transform = 'translate(-50%, -50%)';
            
            // Simple drag logic
            let isDragging = false;
            
            el.addEventListener('mousedown', () => isDragging = true);
            window.addEventListener('mouseup', () => isDragging = false);
            window.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                const rect = layer.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                el.style.left = x + 'px';
                el.style.top = y + 'px';
            });

            layer.appendChild(el);
        }

        function downloadRemix() {
            alert('Remix downloaded! (Simulated)');
        }
    </script>
</div>
