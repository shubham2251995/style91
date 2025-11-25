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
    <!-- Full Bleed Image -->
    <div class="h-[70vh] w-full relative">
        <img src="{{ $product->image_url }}" 
             class="w-full h-full object-cover" 
             alt="{{ $product->name }}">
        
        <!-- Back Button -->
        <a href="{{ route('home') }}" class="absolute top-4 left-4 bg-white/20 backdrop-blur-md p-3 rounded-full text-white hover:bg-white hover:text-black transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>


        <!-- Wishlist & Wardrobe Buttons -->
        <div class="absolute top-4 right-4 flex gap-2">
            <livewire:wishlist-button :productId="$product->id" />
            
            @if($this->digitalWardrobeActive)
                <livewire:wardrobe.add-button :product="$product" />
            @endif
        </div>
    </div>

    <!-- Smart Disclosure Area -->
    <div class="absolute bottom-0 w-full bg-white rounded-t-3xl p-8 -mt-8 shadow-[0_-10px_40px_rgba(0,0,0,0.1)]"
         x-data="{ expanded: false }">
        
        <!-- Minimal Header (Always Visible) -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight mb-1">{{ $product->name }}</h1>
                <p class="text-brand-gray/60 font-mono text-sm">Limited Edition • Drop #001</p>
            </div>
            <div class="text-right">
                <p class="text-sm leading-relaxed mb-6 text-brand-gray">{{ $product->description }}</p>

        <!-- Stock Alert -->
        @if($this->stockAlertActive)
            @if($product->stock_quantity > 0 && $product->stock_quantity <= 10)
                <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-red-500 rounded-full p-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-red-500 text-sm">LOW STOCK ALERT</p>
                            <p class="text-xs text-gray-400">Only {{ $product->stock_quantity }} units remaining. Order soon!</p>
                        </div>
                    </div>
                </div>
            @elseif($product->stock_quantity <= 0)
                <div class="bg-gray-500/10 border border-gray-500/20 rounded-xl p-4 mb-6 text-center">
                    <p class="font-bold text-gray-400 text-sm">OUT OF STOCK</p>
                    <p class="text-xs text-gray-500">This item is currently unavailable.</p>
                </div>
            @endif
        @endif
        <!-- Price -->
        <div class="flex items-baseline gap-3 mb-6">
            <p class="text-4xl font-black text-brand-dark">${{ number_format($product->price, 2) }}</p>
            <a href="{{ route('size-guide') }}" class="text-sm text-brand-accent hover:underline flex items-center gap-1">
                📏 Size Guide
            </a>
        </div>         
                @if($this->tieredPricingActive)
                    <livewire:tiered-pricing :tiers="$product->tiers" />
                @endif
                
                @if($this->socialUnlockActive)
                    <livewire:social-unlock :productId="$product->id" />

                <div class="flex space-x-1 mt-2 justify-end">
                    <span class="w-3 h-3 rounded-full bg-black border border-gray-300"></span>
                    <span class="w-3 h-3 rounded-full bg-gray-400"></span>
                </div>
            </div>
        </div>

        <!-- Primary Action Button (Sticky on Mobile) -->
        <div class="fixed bottom-0 left-0 w-full p-4 bg-white border-t border-gray-100 z-50 md:static md:p-0 md:border-0 md:z-auto">
            <button 
                wire:click="addToCart" 
                wire:loading.attr="disabled"
                @if($product->stock_quantity <= 0) disabled @endif
                class="w-full bg-brand-dark text-white font-bold py-4 rounded-xl relative overflow-hidden transition-all hover:bg-opacity-90 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg md:shadow-none"
                x-data="{ added: @entangle('added') }">
                
                <!-- Loading State -->
                <div wire:loading class="absolute inset-0 flex items-center justify-center bg-brand-dark z-10">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                <div class="absolute inset-0 flex items-center justify-center gap-2 transition-all duration-300"
                     :class="added ? 'translate-y-10 opacity-0' : 'translate-y-0 opacity-100'">
                    <span>ADD TO CART</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>
                </div>

                <div class="absolute inset-0 flex items-center justify-center gap-2 text-green-400 font-bold transition-all duration-300"
                     :class="added ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'">
                    <span>SECURED</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
            </button>
        </div>

        <!-- Crowd Drop Widget -->
        @if($this->crowdDropActive)
            <livewire:crowd-drop.widget :product="$product" />
        @endif

        <!-- Fit Check Gallery -->
        @if($this->fitCheckActive)
            <livewire:fit-check.gallery :productId="$product->id" />
        @endif

        <div class="flex gap-4 mb-8">
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
        <div class="px-6 pb-6">
            <h3 class="font-bold text-lg mb-2 text-brand-dark">Description</h3>
            <div class="prose text-gray-600 text-sm">
                {!! $product->description !!}
            </div>
            
            <!-- Social Share -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <livewire:social-share :url="route('product', $product->slug)" :title="$product->name" />
            </div>
        </div>
        @endif

        <!-- Hidden Details (Smart Disclosure) -->
        <div x-show="expanded" x-collapse class="space-y-6 text-brand-gray/80">
            <p>
                {{ $product->description }}
            </p>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-bold text-black mb-1">Category</h4>
                    <p class="text-sm">{{ $product->category }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-bold text-black mb-1">Material</h4>
                    <p class="text-sm">100% Organic Cotton</p>
                </div>
            </div>
        </div>

        <!-- Expand Trigger -->
        <button @click="expanded = !expanded" class="w-full flex justify-center py-2 text-brand-gray/40 hover:text-brand-black transition-colors">
            <div class="flex flex-col items-center gap-1">
                <span class="text-xs font-mono tracking-widest uppercase" x-text="expanded ? 'LESS INFO' : 'MORE INFO'"></span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 transition-transform duration-300" :class="expanded ? 'rotate-180' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
        </button>
    </div>

    <!-- Reviews Section -->
    <div class="mt-8 px-6 pb-6">
        <livewire:review-form :productId="$product->id" />
    </div>
</div>
