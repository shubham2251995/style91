@props(['content', 'title'])

@php
    $categories = $content['categories'] ?? [];
    
    $getString = function($value) {
        if (is_string($value)) return $value;
        if (is_array($value)) return $value['en'] ?? reset($value) ?? '';
        return (string) $value;
    };
@endphp

<section class="py-12 px-4 md:px-6 lg:px-8 max-w-7xl mx-auto">
    @if($title)
        <div class="text-center mb-10">
            <h2 class="text-4xl md:text-5xl font-black uppercase tracking-tighter text-brand-black mb-3">
                {{ $getString($title) }}
            </h2>
            <div class="w-24 h-1 bg-brand-accent mx-auto"></div>
        </div>
    @endif
    
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        @foreach($categories as $cat)
            @php
                $catName = $getString($cat['name'] ?? 'Category');
                $catUrl = $getString($cat['url'] ?? '#');
                $catImage = $getString($cat['image_url'] ?? 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=600&q=80');
            @endphp
            <a href="{{ $catUrl }}" class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:scale-105">
                <!-- Square Aspect Ratio Container -->
                <div class="aspect-square relative overflow-hidden bg-gray-900">
                    <!-- Category Image -->
                    <img src="{{ $catImage }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                         alt="{{ $catName }}">
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    
                    <!-- Accent Line -->
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-brand-accent transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    
                    <!-- Category Name -->
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <h3 class="text-white font-black text-lg md:text-xl uppercase tracking-tight leading-tight transform translate-y-0 group-hover:-translate-y-1 transition-transform duration-300">
                            {{ $catName }}
                        </h3>
                        
                        <!-- Shop Now Button (appears on hover) -->
                        <div class="flex items-center gap-2 text-brand-accent font-bold text-sm uppercase tracking-wider mt-2 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                            <span>Shop Now</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
