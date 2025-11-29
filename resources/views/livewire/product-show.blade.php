<div class="bg-brand-white text-brand-black relative pb-20">
    {{-- Structured Data for SEO --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": "{{ $product->name }}",
        "image": "{{ $product->image_url }}",
        "description": "{{ strip_tags($product->description) }}",
        "brand": {
            "@type": "Brand",
            "name": "{{ config('app.name') }}"
        },
        "offers": {
            "@type": "Offer",
            "price": "{{ $product->price }}",
            "priceCurrency": "USD",
            "availability": "{{ $product->stock_quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
            "url": "{{ route('product', $product->slug) }}"
        }
    }
    </script>
    {{-- End Structured Data --}}
    <!-- Full Bleed Image (Responsive Height) -->
    <div class="h-[65vh] md:h-[85vh] w-full relative">
        <img src="{{ $product->image_url }}" 
             class="w-full h-full object-cover" 
             alt="{{ $product->name }}">
        
        <!-- Back Button -->
        <a href="{{ route('home') }}" class="absolute top-4 left-4 bg-white/20 backdrop-blur-md p-3 rounded-full text-white hover:bg-white hover:text-black transition-all z-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>


        <!-- Wishlist & Wardrobe Buttons -->
        <div class="absolute top-4 right-4 flex gap-2 z-10">
            <livewire:wishlist-button :productId="$product->id" />
            
            @if($this->digitalWardrobeActive)
                <livewire:wardrobe.add-button :product="$product" />
            @endif
        </div>
        
        <!-- Gradient Overlay for Text Readability -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
    </div>

    <!-- Smart Disclosure Area -->
    <div class="relative -mt-12 bg-white rounded-t-[2.5rem] px-6 pt-10 pb-32 md:pb-12 shadow-[0_-10px_40px_rgba(0,0,0,0.1)] min-h-[50vh]"
         x-data="{ expanded: false }">
        
        <!-- Drag Handle (Visual Cue) -->
        <div class="absolute top-3 left-1/2 -translate-x-1/2 w-12 h-1.5 bg-gray-200 rounded-full md:hidden"></div>
        
        <!-- Minimal Header (Always Visible) -->
        <div class="flex flex-col md:flex-row justify-between items-start mb-8 gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    @if($product->activeFlashSale)
                        <span class="px-2 py-0.5 bg-red-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-sm animate-pulse">Flash Sale Ends in {{ $product->activeFlashSale->end_time->diffForHumans() }}</span>
                    @else
                        <span class="px-2 py-0.5 bg-brand-accent text-brand-black text-[10px] font-bold uppercase tracking-wider rounded-sm">New Arrival</span>
                    @endif
                    <p class="text-brand-gray/60 font-mono text-xs uppercase tracking-widest">Drop #001</p>
                </div>
                <h1 class="text-3xl md:text-5xl font-black tracking-tight text-brand-black leading-none mb-2">{{ $product->name }}</h1>
            </div>
            
            <!-- Price Block -->
            <div class="flex flex-col items-end">
                <div class="flex items-baseline gap-2">
                    @if($product->activeFlashSale)
                        <p class="text-3xl md:text-4xl font-black text-red-600">₹{{ number_format($product->activeFlashSale->pivot->fixed_price ?? ($variantPrice * 80 * (1 - $product->activeFlashSale->pivot->discount_percentage/100))) }}</p>
                        <span class="text-lg text-gray-400 line-through font-medium">₹{{ number_format($variantPrice * 80) }}</span>
                    @else
                        <p class="text-3xl md:text-4xl font-black text-brand-black">₹{{ number_format($variantPrice * 80) }}</p>
                        <span class="text-lg text-gray-400 line-through font-medium">₹{{ number_format(($variantPrice * 80) + 499) }}</span>
                    @endif
                </div>
                <a href="{{ route('size-guide') }}" class="text-xs font-bold text-brand-accent hover:text-brand-black uppercase tracking-wider flex items-center gap-1 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    Size Guide
                </a>
            </div>
        </div>

        <!-- Variant Selectors -->
        @if($product->hasVariants())
            <div class="mb-8 space-y-4">
                @foreach($availableOptions as $option)
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">{{ $option['name'] }}</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($option['values'] as $value)
                                <button 
                                    wire:click="$set('selectedOptions.{{ $option['name'] }}', '{{ $value }}')"
                                    class="px-4 py-2 rounded-lg border-2 text-sm font-bold transition-all
                                    {{ isset($selectedOptions[$option['name']]) && $selectedOptions[$option['name']] == $value 
                                        ? 'border-brand-black bg-brand-black text-white' 
                                        : 'border-gray-200 text-gray-600 hover:border-gray-300' }}"
                                >
                                    {{ $value }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Stock Alert -->
        @if($this->stockAlertActive)
            @if($variantStock > 0 && $variantStock <= 10)
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8">
                    <div class="flex items-center gap-3">
                        <div class="animate-pulse">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-red-500">
                                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-black text-red-600 text-xs uppercase tracking-wider">Low Stock Alert</p>
                            <p class="text-xs text-red-500 font-medium">Only {{ $variantStock }} units remaining. Secure yours now.</p>
                        </div>
                    </div>
                </div>
            @elseif($variantStock <= 0)
                <div class="bg-gray-100 border-l-4 border-gray-400 p-4 mb-8">
                    <p class="font-black text-gray-500 text-xs uppercase tracking-wider">Out of Stock</p>
                    <p class="text-xs text-gray-500">This item is currently unavailable.</p>
                </div>
            @endif
        @endif
                
        @if($this->tieredPricingActive)
            <livewire:tiered-pricing :tiers="$product->tiers" />
        @endif
        
        @if($this->socialUnlockActive)
            <livewire:social-unlock :productId="$product->id" />
        @endif

        <!-- Primary Action Button (Sticky on Mobile with Safe Area) -->
        <div class="fixed bottom-16 left-0 w-full p-4 z-40 md:static md:p-0 md:mb-8 md:z-auto pointer-events-none">
            <div class="pointer-events-auto max-w-md mx-auto md:max-w-none flex gap-4">
                <button 
                    wire:click="addToCart" 
                    wire:loading.attr="disabled"
                    @if($variantStock <= 0) disabled @endif
                    class="flex-1 bg-brand-black text-white font-black text-lg py-4 rounded-xl relative overflow-hidden transition-all hover:scale-[1.02] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xl shadow-brand-accent/20"
                    x-data="{ added: @entangle('added') }">
                    
                    <!-- Loading State -->
                    <div wire:loading wire:target="addToCart" class="absolute inset-0 flex items-center justify-center bg-brand-black z-10">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>

                    <div class="absolute inset-0 flex items-center justify-center gap-3 transition-all duration-300"
                         :class="added ? 'translate-y-10 opacity-0' : 'translate-y-0 opacity-100'">
                        <span>ADD TO CART</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 5c.07.277-.029.561-.225.761A1.125 1.125 0 0119.66 15H4.34a1.125 1.125 0 01-.894-1.732l1.263-5a1.125 1.125 0 011.092-.852H18.57c.47 0 .91.247 1.092.852z" />
                        </svg>
                    </div>

                    <div class="absolute inset-0 flex items-center justify-center gap-2 text-brand-accent font-black transition-all duration-300"
                         :class="added ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'">
                        <span>SECURED</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                </button>

                <button 
                    wire:click="buyNow" 
                    wire:loading.attr="disabled"
                    @if($variantStock <= 0) disabled @endif
                    class="flex-1 bg-brand-accent text-brand-black font-black text-lg py-4 rounded-xl relative overflow-hidden transition-all hover:scale-[1.02] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-brand-accent/30">
                    <div wire:loading wire:target="buyNow" class="absolute inset-0 flex items-center justify-center bg-brand-accent z-10">
                        <svg class="animate-spin h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <span>BUY NOW</span>
                </button>
            </div>
        </div>

        <!-- Crowd Drop Widget -->
        @if($this->crowdDropActive)
            <div class="mb-8">
                <livewire:crowd-drop.widget :product="$product" />
            </div>
        @endif

        <!-- Fit Check Gallery -->
        @if($this->fitCheckActive)
            <div class="mb-8">
                <livewire:fit-check.gallery :productId="$product->id" />
            </div>
        @endif

        <div class="flex gap-4 mb-8 overflow-x-auto pb-2 scrollbar-hide">
            @if($this->squadModeActive)
                <livewire:squad.widget :product="$product" />
            @endif

            @if($this->rafflesActive)
                <livewire:raffle.widget :product="$product" />
            @endif
        </div>

        @if($this->smartBundlingActive)
            <livewire:smart-bundling :product="$product" />
        @endif

        <!-- Product Description -->
        @if($product->description)
        <div class="pb-6">
            <h3 class="font-black text-lg mb-4 text-brand-black uppercase tracking-tight">Description</h3>
            <div class="prose text-gray-600 text-sm leading-relaxed">
                {!! $product->description !!}
            </div>
            
            <!-- Social Share & Ask for Advice -->
            <div class="mt-8 pt-8 border-t border-gray-100 space-y-4">
                <h4 class="font-bold text-sm text-gray-900 uppercase tracking-wider">Share & Get Feedback</h4>
                <div class="flex flex-wrap gap-3">
                    <div class="flex-1 min-w-[200px]">
                        <livewire:social-share :url="route('product', $product->slug)" :title="$product->name" />
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <livewire:ask-for-advice :productId="$product->id" :productName="$product->name" />
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Hidden Details (Smart Disclosure) -->
        <div x-show="expanded" x-collapse class="space-y-6 text-brand-gray/80 border-t border-gray-100 pt-6">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-xl">
                    <h4 class="font-bold text-black mb-1 text-xs uppercase tracking-wider">Category</h4>
                    <p class="text-sm font-medium">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl">
                    <h4 class="font-bold text-black mb-1 text-xs uppercase tracking-wider">Material</h4>
                    <p class="text-sm font-medium">100% Organic Cotton</p>
                </div>
            </div>
        </div>

        <!-- Expand Trigger -->
        <button @click="expanded = !expanded" class="w-full flex justify-center py-4 text-gray-400 hover:text-brand-black transition-colors">
            <div class="flex flex-col items-center gap-1">
                <span class="text-[10px] font-black tracking-widest uppercase" x-text="expanded ? 'LESS INFO' : 'MORE INFO'"></span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 transition-transform duration-300" :class="expanded ? 'rotate-180' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
        </button>
    </div>

    <!-- Complete the Look (AI Stylist) -->
    @if(count($completeTheLookProducts) > 0)
    <div class="mt-16">
        <h3 class="text-2xl font-black uppercase tracking-tighter mb-6">Complete the Look</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($completeTheLookProducts as $lookItem)
                <a href="{{ route('product', $lookItem->slug) }}" class="group">
                    <div class="aspect-[3/4] bg-gray-100 rounded-xl overflow-hidden mb-3 relative">
                        @if($lookItem->image_url)
                            <img src="{{ $lookItem->image_url }}" alt="{{ $lookItem->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                    </div>
                    <h4 class="font-bold text-sm uppercase tracking-wide truncate">{{ $lookItem->name }}</h4>
                    <p class="text-sm text-gray-500">₹{{ number_format($lookItem->price, 2) }}</p>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Reviews Section -->
    <div class="px-6 pb-24 max-w-7xl mx-auto">
        <livewire:review-form :productId="$product->id" />
    </div>
</div>
```
