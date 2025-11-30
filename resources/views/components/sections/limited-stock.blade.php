{{-- Limited Stock Alert Section --}}
<section class="py-12 bg-gradient-to-r from-orange-600/10 to-red-600/10 border-y border-orange-500/20">
    <div class="container mx-auto px-4">
        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 bg-orange-500/20 px-4 py-2 rounded-full mb-4 animate-pulse">
                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-orange-400 font-bold uppercase text-sm">Limited Stock Alert</span>
            </div>
            
            <h2 class="text-4xl font-bold mb-2">{{ $section->title }}</h2>
            @if($section->subtitle)
            <p class="text-gray-400 text-lg">{{ $section->subtitle }}</p>
            @endif
        </div>

        {{-- Products Grid --}}
        @if(isset($section->sectionProducts) && $section->sectionProducts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ $section->settings['grid_columns'] ?? 4 }} gap-6">
            @foreach($section->sectionProducts as $product)
            <div class="group bg-white/5 border-2 border-orange-500/30 rounded-xl overflow-hidden hover:border-orange-500 transition-all duration-300 relative">
                {{-- Stock Warning Banner --}}
                <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-orange-600 to-red-600 text-white py-2 px-4 text-center font-bold text-sm z-10 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    ONLY {{ $product->stock }} LEFT IN STOCK!
                </div>

                <a href="{{ route('product', $product->slug) }}" class="block">
                    {{-- Product Image --}}
                    <div class="relative aspect-square overflow-hidden bg-gray-800 mt-10">
                        <img src="{{ $product->image_url ?? '/images/placeholder.jpg' }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>

                    {{-- Product Info --}}
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $product->name }}</h3>
                        
                        {{-- Stock Progress --}}
                        <div class="mb-3">
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-gray-400">Stock Level</span>
                                <span class="text-orange-400 font-bold">{{ $product->stock }} units</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-orange-500 to-red-500 h-full rounded-full transition-all" 
                                     style="width: {{ min(($product->stock / 50) * 100, 100) }}%"></div>
                            </div>
                        </div>
                        
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

                        <button class="w-full bg-gradient-to-r from-orange-600 to-red-600 text-white py-3 rounded-lg font-bold hover:from-orange-700 hover:to-red-700 transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Grab It Now!
                        </button>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 text-gray-400">
            <p class="text-lg">All products are well-stocked! ✅</p>
        </div>
        @endif
    </div>
</section>
