{{-- Trending Products Section --}}
<section class="py-12 bg-gradient-to-br from-blue-600/5 to-cyan-600/5">
    <div class="container mx-auto px-4">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-4xl font-bold">{{ $section->title }}</h2>
                    @if($section->subtitle)
                    <p class="text-gray-400">{{ $section->subtitle }}</p>
                    @endif
                </div>
            </div>
            
            @if($section->link_url)
            <a href="{{ $section->link_url }}" class="text-brand-accent hover:underline flex items-center gap-2">
                {{ $section->link_text ?? 'View All' }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            @endif
        </div>

        {{-- Products Grid --}}
        @if(isset($section->sectionProducts) && $section->sectionProducts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ $section->settings['grid_columns'] ?? 4 }} gap-6">
            @foreach($section->sectionProducts as $index => $product)
            <div class="group bg-white/5 border border-white/10 rounded-xl overflow-hidden hover:border-blue-500/50 transition-all duration-300 relative">
                {{-- Trending Badge --}}
                <div class="absolute top-3 right-3 bg-blue-500 text-white w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg z-10 shadow-lg">
                    #{{ $index + 1 }}
                </div>

                <a href="{{ route('product', $product->slug) }}" class="block">
                    {{-- Product Image --}}
                    <div class="relative aspect-square overflow-hidden bg-gray-800">
                        <img src="{{ $product->image_url ?? '/images/placeholder.jpg' }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        
                        {{-- Trending Indicator --}}
                        <div class="absolute bottom-3 left-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                            </svg>
                            Trending
                        </div>
                    </div>

                    {{-- Product Info --}}
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 line-clamp-2 group-hover:text-blue-400 transition">
                            {{ $product->name }}
                        </h3>
                        
                        <div class="flex items-center justify-between mb-3">
                            @if($product->sale_price)
                            <div class="flex items-center gap-2">
                                <span class="text-xl font-bold text-brand-accent">₹{{ number_format($product->sale_price) }}</span>
                                <span class="text-gray-400 line-through text-sm">₹{{ number_format($product->price) }}</span>
                            </div>
                            @else
                            <span class="text-xl font-bold">₹{{ number_format($product->price) }}</span>
                            @endif
                        </div>

                        <button class="w-full bg-blue-600 text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                            Add to Cart
                        </button>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
