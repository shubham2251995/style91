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
        <div class="fixed inset-0 bg-black/50" wire:click="close"></div>

        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div 
                class="relative bg-white rounded-2xl shadow-2xl max-w-4xl w-full overflow-hidden"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                @click.away="$wire.close()"
            >
                <!-- Close Button -->
                <button 
                    wire:click="close"
                    class="absolute top-4 right-4 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="grid md:grid-cols-2 gap-6 p-6">
                    <!-- Product Image -->
                    <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
                        <img src="{{ $product->image_url }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                    </div>

                    <!-- Product Details -->
                    <div class="flex flex-col">
                        <h2 class="text-2xl font-bold text-brand-dark mb-2">{{ $product->name }}</h2>
                        <p class="text-3xl font-bold text-brand-accent mb-4">${{ number_format($product->price, 2) }}</p>

                        @if($product->description)
                            <p class="text-gray-600 text-sm mb-6 line-clamp-3">{{ strip_tags($product->description) }}</p>
                        @endif

                        <!-- Stock Status -->
                        @if($product->stock_quantity > 0)
                            <p class="text-green-600 text-sm font-bold mb-4">✓ In Stock ({{ $product->stock_quantity }} available)</p>
                        @else
                            <p class="text-red-600 text-sm font-bold mb-4">Out of Stock</p>
                        @endif

                        <!-- Actions -->
                        <div class="mt-auto space-y-3">
                            @if($product->stock_quantity > 0)
                                <livewire:quick-add-to-cart :productId="$product->id" :key="'modal-cart-'.$product->id" />
                            @else
                                <livewire:stock-alert-button :productId="$product->id" :key="'modal-alert-'.$product->id" />
                            @endif

                            <a 
                                href="{{ route('product', $product->slug) }}"
                                class="block w-full text-center bg-gray-200 text-brand-dark font-bold py-3 rounded-lg hover:bg-gray-300 transition"
                            >
                                VIEW FULL DETAILS
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
