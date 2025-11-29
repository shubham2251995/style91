<div>
    @if($show && $product)
    {{-- Enhanced Quick View Modal --}}
    <div 
        x-data="{ 
            show: @entangle('show'),
            currentImage: 0,
            selectedSize: null,
            selectedColor: null,
            quantity: 1,
            activeTab: 'details'
        }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
        @keydown.escape.window="$wire.close()"
    >
        {{-- Background Overlay --}}
        <div class="fixed inset-0 bg-black/70 backdrop-blur-md" wire:click="close"></div>

        {{-- Modal Content --}}
        <div class="flex items-center justify-center min-h-screen p-4">
            <div 
                class="relative bg-white rounded-2xl shadow-2xl max-w-6xl w-full overflow-hidden"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                @click.away="$wire.close()"
            >
                {{-- Close Button --}}
                <button 
                    wire:click="close"
                    class="absolute top-4 right-4 z-20 bg-white/90 backdrop-blur rounded-full p-2.5 shadow-lg hover:bg-brand-accent hover:text-white transition-all duration-200 group"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="grid md:grid-cols-2 gap-0">
                    {{-- Left: Product Images --}}
                    <div class="relative bg-gray-50">
                        {{-- Main Image Display --}}
                        <div class="aspect-square relative overflow-hidden group">
                            <img 
                                src="{{ $product->image_url }}" 
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                                alt="{{ $product->name }}"
                            >
                            
                            {{-- Image Navigation Arrows (if multiple images) --}}
                            {{-- Placeholder for future multiple image support --}}
                            
                            {{-- Zoom Indicator --}}
                            <div class="absolute bottom-4 right-4 bg-black/60 text-white px-3 py-1.5 rounded-full text-xs font-medium backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                </svg>
                                Hover to zoom
                            </div>
                        </div>
                        
                        {{-- Image Thumbnails (Placeholder) --}}
                        {{-- Will be implemented when multiple images are supported --}}
                    </div>

                    {{-- Right: Product Details --}}
                    <div class="flex flex-col p-6 md:p-8 max-h-[600px] overflow-y-auto">
                        {{-- Product Header --}}
                        <div class="mb-6">
                            {{-- Rating --}}
                            @if(isset($product->avg_rating) && $product->avg_rating > 0)
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="flex gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($product->avg_rating))
                                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-600">({{ $product->review_count ?? 0 }} reviews)</span>
                                </div>
                            @endif
                            
                            {{-- Product Name --}}
                            <h2 class="text-2xl md:text-3xl font-black text-brand-black mb-2 leading-tight">
                                {{ $product->name }}
                            </h2>
                            
                            {{-- Price --}}
                            <div class="flex items-baseline gap-3 mb-4">
                                @if($product->activeFlashSale)
                                    <p class="text-3xl font-black text-red-600">
                                        ₹{{ number_format(($product->price * 80) * (1 - $product->activeFlashSale->pivot->discount_percentage/100)) }}
                                    </p>
                                    <span class="text-lg text-gray-400 line-through">
                                        ₹{{ number_format($product->price * 80) }}
                                    </span>
                                    <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded">
                                        {{ $product->activeFlashSale->pivot->discount_percentage }}% OFF
                                    </span>
                                @else
                                    <p class="text-3xl font-black text-brand-black">
                                        ₹{{ number_format($product->price * 80) }}
                                    </p>
                                @endif
                            </div>
                            
                            {{-- Stock Status --}}
                            @if($product->stock_quantity > 0)
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    <p class="text-green-600 text-sm font-bold uppercase tracking-wider">
                                        In Stock 
                                        @if($product->stock_quantity <= 10)
                                            (Only {{ $product->stock_quantity }} left!)
                                        @endif
                                    </p>
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    <p class="text-red-600 text-sm font-bold uppercase tracking-wider">Out of Stock</p>
                                </div>
                            @endif
                        </div>

                        {{-- Variant Selection --}}
                        @if($product->hasVariants())
                            @php
                                $colorOptions = $product->variantOptions->firstWhere('name', 'Color');
                                $sizeOptions = $product->variantOptions->firstWhere('name', 'Size');
                                $colors = $colorOptions ? $colorOptions->values : [];
                                $sizes = $sizeOptions ? $sizeOptions->values : [];
                            @endphp
                            
                            {{-- Color Selection --}}
                            @if($colors && count($colors) > 0)
                                <div class="mb-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">
                                            Color: <span x-text="selectedColor || 'Select'"></span>
                                        </label>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($colors as $color)
                                            @php
                                                $colorMap = [
                                                    'Black' => 'bg-black',
                                                    'White' => 'bg-white border-2 border-gray-300',
                                                    'Red' => 'bg-red-600',
                                                    'Blue' => 'bg-blue-600',
                                                    'Green' => 'bg-green-600',
                                                    'Yellow' => 'bg-yellow-400',
                                                    'Pink' => 'bg-pink-500',
                                                    'Purple' => 'bg-purple-600',
                                                    'Gray' => 'bg-gray-500',
                                                    'Navy' => 'bg-blue-900',
                                                    'Beige' => 'bg-amber-100 border-2 border-amber-300',
                                                    'Brown' => 'bg-amber-800',
                                                    'Orange' => 'bg-orange-500',
                                                ];
                                                $bgClass = $colorMap[$color] ?? 'bg-gray-400';
                                            @endphp
                                            <button 
                                                @click="selectedColor = '{{ $color }}'"
                                                :class="selectedColor === '{{ $color }}' ? 'ring-2 ring-brand-accent ring-offset-2' : ''"
                                                class="w-10 h-10 rounded-full {{ $bgClass }} shadow-md hover:scale-110 transition-all duration-200"
                                                title="{{ $color }}"
                                            ></button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            {{-- Size Selection --}}
                            @if($sizes && count($sizes) > 0)
                                <div class="mb-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">
                                            Size: <span x-text="selectedSize || 'Select'"></span>
                                        </label>
                                        <button class="text-xs text-brand-accent hover:underline font-medium">Size Guide</button>
                                    </div>
                                    <div class="grid grid-cols-5 gap-2">
                                        @foreach($sizes as $size)
                                            <button 
                                                @click="selectedSize = '{{ $size }}'"
                                                :class="selectedSize === '{{ $size }}' ? 'bg-brand-black text-white border-brand-black' : 'bg-white text-gray-700 border-gray-300 hover:border-brand-accent'"
                                                class="border-2 px-3 py-2.5 text-sm font-bold uppercase tracking-wider transition-all duration-200"
                                            >
                                                {{ $size }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif

                        {{-- Quantity Selector --}}
                        @if($product->stock_quantity > 0)
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Quantity</label>
                                <div class="flex items-center gap-4">
                                    <button 
                                        @click="quantity = Math.max(1, quantity - 1)"
                                        class="w-10 h-10 flex items-center justify-center border-2 border-gray-300 hover:border-brand-accent transition-colors"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </button>
                                    <span class="text-lg font-bold w-12 text-center" x-text="quantity"></span>
                                    <button 
                                        @click="quantity = Math.min({{ $product->stock_quantity }}, quantity + 1)"
                                        class="w-10 h-10 flex items-center justify-center border-2 border-gray-300 hover:border-brand-accent transition-colors"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="space-y-3 mb-6">
                            @if($product->stock_quantity > 0)
                                <livewire:quick-add-to-cart :productId="$product->id" :key="'modal-cart-'.$product->id" />
                            @else
                                <livewire:stock-alert-button :productId="$product->id" :key="'modal-alert-'.$product->id" />
                            @endif

                            <a 
                                href="{{ route('product', $product->slug) }}"
                                class="block w-full text-center bg-transparent border-2 border-brand-black text-brand-black font-bold text-sm uppercase tracking-widest py-3.5 hover:bg-brand-black hover:text-white transition-all duration-300"
                            >
                                View Full Details
                            </a>
                        </div>

                        {{-- Product Features --}}
                        <div class="border-t border-gray-200 pt-6 mb-6 space-y-3">
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Free delivery on orders over ₹499</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Easy 7-day returns & exchanges</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Cash on delivery available</span>
                            </div>
                        </div>

                        {{-- Tabbed Content --}}
                        <div class="border-t border-gray-200 pt-6">
                            {{-- Tab Headers --}}
                            <div class="flex border-b border-gray-200 mb-4">
                                <button 
                                    @click="activeTab = 'details'"
                                    :class="activeTab === 'details' ? 'border-b-2 border-brand-accent text-brand-accent' : 'text-gray-500'"
                                    class="px-4 py-2 text-sm font-bold uppercase tracking-wider transition-colors"
                                >
                                    Details
                                </button>
                                <button 
                                    @click="activeTab = 'delivery'"
                                    :class="activeTab === 'delivery' ? 'border-b-2 border-brand-accent text-brand-accent' : 'text-gray-500'"
                                    class="px-4 py-2 text-sm font-bold uppercase tracking-wider transition-colors"
                                >
                                    Delivery
                                </button>
                                <button 
                                    @click="activeTab = 'share'"
                                    :class="activeTab === 'share' ? 'border-b-2 border-brand-accent text-brand-accent' : 'text-gray-500'"
                                    class="px-4 py-2 text-sm font-bold uppercase tracking-wider transition-colors"
                                >
                                    Share
                                </button>
                            </div>

                            {{-- Tab Content --}}
                            <div>
                                {{-- Details Tab --}}
                                <div x-show="activeTab === 'details'" class="text-sm text-gray-600 leading-relaxed">
                                    @if($product->description)
                                        <p>{{ strip_tags($product->description) }}</p>
                                    @else
                                        <p>No description available for this product.</p>
                                    @endif
                                </div>

                                {{-- Delivery Tab --}}
                                <div x-show="activeTab === 'delivery'" class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Check Delivery</label>
                                        <div class="flex gap-2">
                                            <input 
                                                type="text" 
                                                placeholder="Enter PIN code"
                                                class="flex-1 px-4 py-2 border-2 border-gray-300 focus:border-brand-accent focus:ring-0 text-sm"
                                            >
                                            <button class="bg-brand-accent text-white px-6 py-2 font-bold text-sm uppercase hover:bg-brand-dark transition-colors">
                                                Check
                                            </button>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">Estimated delivery: 3-5 business days</p>
                                    </div>
                                </div>

                                {{-- Share Tab --}}
                                <div x-show="activeTab === 'share'" class="space-y-4">
                                    <p class="text-sm text-gray-600 mb-3">Share this product:</p>
                                    <div class="flex gap-3">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('product', $product->slug)) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                            Facebook
                                        </a>
                                        <a href="https://api.whatsapp.com/send?text={{ urlencode($product->name . ' - ' . route('product', $product->slug)) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.304-1.654a11.882 11.882 0 005.713 1.456h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                            WhatsApp
                                        </a>
                                    </div>
                                    <div class="pt-3 border-t border-gray-200">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Copy Link</label>
                                        <div class="flex gap-2">
                                            <input 
                                                type="text" 
                                                value="{{ route('product', $product->slug) }}"
                                                readonly
                                                class="flex-1 px-4 py-2 border-2 border-gray-300 bg-gray-50 text-sm"
                                            >
                                            <button 
                                                @click="navigator.clipboard.writeText('{{ route('product', $product->slug) }}'); alert('Link copied!')"
                                                class="bg-gray-800 text-white px-6 py-2 font-bold text-sm uppercase hover:bg-black transition-colors"
                                            >
                                                Copy
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
