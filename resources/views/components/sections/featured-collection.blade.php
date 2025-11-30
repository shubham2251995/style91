{{-- Featured Collection Section --}}
<section class="py-12">
    <div class="container mx-auto px-4">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-4xl font-bold mb-2">{{ $section->title }}</h2>
                @if($section->subtitle)
                <p class="text-gray-400 text-lg">{{ $section->subtitle }}</p>
                @endif
            </div>
            
            @if($section->link_url)
            <a href="{{ $section->link_url }}" 
               class="flex items-center gap-2 text-brand-accent hover:gap-3 transition-all group">
                <span class="font-medium">{{ $section->link_text ?? 'View All' }}</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
            @endif
        </div>

        {{-- Products Grid --}}
        @if(isset($section->sectionProducts) && $section->sectionProducts->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-{{ $section->settings['grid_columns'] ?? 4 }} gap-4 md:gap-6">
            @foreach($section->sectionProducts as $product)
            <div class="group bg-white/5 border border-white/10 rounded-xl overflow-hidden hover:border-brand-accent/50 transition-all duration-300">
                <a href="{{ route('product', $product->slug) }}" class="block">
                    {{-- Product Image --}}
                    <div class="relative aspect-square overflow-hidden bg-gray-800">
                        @if($product->stock <= 5)
                        <div class="absolute top-3 left-3 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold z-10">
                            Only {{ $product->stock }} Left!
                        </div>
                        @endif
                        
                        <img src="{{ $product->image_url ?? '/images/placeholder.jpg' }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>

                    {{-- Product Info --}}
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 line-clamp-2 group-hover:text-brand-accent transition">
                            {{ $product->name }}
                        </h3>
                        
                        @if($product->short_description)
                        <p class="text-sm text-gray-400 mb-3 line-clamp-2">{{ $product->short_description }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                @if($product->sale_price)
                                <span class="text-xl font-bold text-brand-accent">₹{{ number_format($product->sale_price) }}</span>
                                <span class="text-gray-400 line-through text-sm">₹{{ number_format($product->price) }}</span>
                                @else
                                <span class="text-xl font-bold">₹{{ number_format($product->price) }}</span>
                                @endif
                            </div>
                            
                            <button class="p-2 bg-brand-accent/20 rounded-lg hover:bg-brand-accent hover:text-black transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
