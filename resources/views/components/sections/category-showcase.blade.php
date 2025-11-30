{{-- Category Showcase Section --}}
<section class="py-12">
    <div class="container mx-auto px-4">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-2">{{ $section->title }}</h2>
            @if($section->subtitle)
            <p class="text-gray-400 text-lg">{{ $section->subtitle }}</p>
            @endif
        </div>

        {{-- Category Grid --}}
        @if(isset($section->category) && isset($section->sectionProducts))
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Category Card --}}
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-brand-accent/20 to-blue-600/10 border border-brand-accent/30 rounded-2xl p-8 h-full flex flex-col justify-center">
                    <div class="w-16 h-16 bg-brand-accent/20 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-brand-accent" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-3xl font-bold mb-4">{{ $section->category->name }}</h3>
                    
                    @if($section->category->description)
                    <p class="text-gray-400 mb-6 leading-relaxed">{{ $section->category->description }}</p>
                    @endif
                    
                    <div class="mb-6">
                        <div class="flex items-center gap-2 text-sm text-gray-400 mb-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                            </svg>
                            {{ $section->sectionProducts->count() }}+ Products Available
                        </div>
                    </div>
                    
                    <a href="{{ $section->link_url ?? '/category/' . $section->category->slug }}" 
                       class="inline-flex items-center justify-center gap-2 bg-brand-accent text-black px-6 py-3 rounded-xl font-bold hover:bg-blue-500 transition-all group">
                        <span>Shop {{ $section->category->name }}</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Products Grid --}}
            <div class="lg:col-span-2">
                <div class="grid grid-cols-2 gap-4">
                    @foreach($section->sectionProducts->take(4) as $product)
                    <div class="group bg-white/5 border border-white/10 rounded-xl overflow-hidden hover:border-brand-accent/50 transition-all">
                        <a href="{{ route('product', $product->slug) }}">
                            <div class="relative aspect-square overflow-hidden bg-gray-800">
                                <img src="{{ $product->image_url ?? '/images/placeholder.jpg' }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            
                            <div class="p-3">
                                <h4 class="font-medium text-sm mb-2 line-clamp-2 group-hover:text-brand-accent transition">
                                    {{ $product->name }}
                                </h4>
                                
                                <div class="flex items-center gap-2">
                                    @if($product->sale_price)
                                    <span class="font-bold text-brand-accent">₹{{ number_format($product->sale_price) }}</span>
                                    <span class="text-xs text-gray-400 line-through">₹{{ number_format($product->price) }}</span>
                                    @else
                                    <span class="font-bold">₹{{ number_format($product->price) }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
