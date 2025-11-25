<div>
    @if($show && $product)
    <!-- Modal Overlay -->
    <div 
        x-data="{ show: @entangle('show') }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <!-- Background Overlay -->
        <div class="fixed inset-0 bg-black/60 backdrop-blur-md" wire:click="close"></div>

        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div 
                class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full overflow-hidden"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                @click.away="$wire.close()"
            >
                <!-- Close Button -->
                <button 
                    wire:click="close"
                    class="absolute top-4 right-4 z-10 bg-white/80 backdrop-blur rounded-full p-2 shadow-sm hover:bg-brand-accent transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="grid md:grid-cols-2 gap-0">
                    <!-- Product Image -->
                    <div class="aspect-square md:aspect-auto h-full bg-gray-100 relative">
                        <img src="{{ $product->image_url }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
                    </div>

                    <!-- Product Details -->
                    <div class="flex flex-col p-8 md:p-12">
                        <div class="mb-auto">
                            <span class="bg-brand-accent text-brand-black text-[10px] font-black uppercase tracking-widest px-2 py-1 mb-4 inline-block">Quick View</span>
                            <h2 class="text-3xl font-black text-brand-black mb-2 leading-none">{{ $product->name }}</h2>
                            <p class="text-2xl font-bold text-gray-900 mb-6">₹{{ number_format($product->price * 80) }}</p>

                            @if($product->description)
                                <p class="text-gray-600 text-sm mb-8 leading-relaxed line-clamp-3">{{ strip_tags($product->description) }}</p>
                            @endif

                            <!-- Stock Status -->
                            @if($product->stock_quantity > 0)
                                <div class="flex items-center gap-2 mb-8">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    <p class="text-green-600 text-xs font-bold uppercase tracking-wider">In Stock ({{ $product->stock_quantity }} left)</p>
                                </div>
                            @else
                                <div class="flex items-center gap-2 mb-8">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    <p class="text-red-600 text-xs font-bold uppercase tracking-wider">Out of Stock</p>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="space-y-3 mt-8">
                            @if($product->stock_quantity > 0)
                                <livewire:quick-add-to-cart :productId="$product->id" :key="'modal-cart-'.$product->id" />
                            @else
                                <livewire:stock-alert-button :productId="$product->id" :key="'modal-alert-'.$product->id" />
                            @endif

                            <a 
                                href="{{ route('product', $product->slug) }}"
                                class="block w-full text-center bg-transparent border-2 border-brand-black text-brand-black font-bold text-sm uppercase tracking-widest py-4 rounded-none hover:bg-brand-black hover:text-white transition-all duration-300"
                            >
                                View Full Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
