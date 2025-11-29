<div class="space-y-12 pb-24">
    @if($sections->count() > 0)
        {{-- Render dynamic sections from database --}}
        @foreach($sections as $section)
            @php
                $componentMap = [
                    'hero' => 'sections.hero',
                    'categories' => 'sections.categories',
                    'featured_products' => 'sections.featured-products',
                    'banner' => 'sections.banner',
                    'text_block' => 'sections.text-block',
                    'video' => 'sections.video',
                    'custom_html' => 'sections.custom-html',
                ];
                $component = $componentMap[$section->type] ?? null;
            @endphp

            @if($component && view()->exists('components.' . $component))
                <x-dynamic-component :component="$component" :content="$section->content" :title="$section->title" />
            @endif
        @endforeach
    @else
        {{-- Fallback: Static content when no sections exist --}}
        
        <!-- Hero Section (Premium Full Screen) -->
        <section class="relative w-full h-[85vh] md:h-[80vh] overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1523396870179-16bed9562000?q=80&w=2000&auto=format&fit=crop" 
                     class="w-full h-full object-cover object-center" 
                     alt="Hero Background">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
            </div>
            
            <div class="absolute bottom-0 left-0 w-full p-8 md:p-16 flex flex-col items-start justify-end h-full">
                <span class="bg-brand-accent text-brand-black text-xs font-black tracking-widest uppercase px-3 py-1 mb-4">New Collection</span>
                <h2 class="text-white font-black text-5xl md:text-7xl mb-4 leading-tight">STREET<br>CULTURE</h2>
                <p class="text-gray-300 text-sm md:text-lg mb-8 max-w-md">Redefining urban fashion with premium cuts and bold designs. Up to 60% off on selected items.</p>
                <button class="bg-white text-brand-black px-8 py-4 rounded-none font-black text-sm uppercase tracking-widest hover:bg-brand-accent transition-colors duration-300">
                    Shop The Drop
                </button>
            </div>
        </section>

        <!-- Categories Grid (Responsive) -->
        <section class="px-4 md:px-8 py-12 max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-8">
                <h3 class="font-black text-2xl md:text-3xl text-brand-black uppercase tracking-tight">Shop By Category</h3>
                <a href="#" class="text-xs font-bold text-gray-400 hover:text-brand-black uppercase tracking-widest">View All</a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
                @foreach(['T-Shirts', 'Oversized', 'Hoodies', 'Accessories', 'Bottoms', 'Sneakers', 'Sale', 'Exclusives'] as $cat)
                <a href="#" class="group relative aspect-square overflow-hidden bg-gray-100">
                    <img src="https://source.unsplash.com/random/400x400/?fashion,{{ $cat }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-300"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="text-white font-bold text-lg md:text-xl uppercase tracking-wide">{{ $cat }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </section>

        <!-- Design of the Day (Feature Card) -->
        <section class="px-4 md:px-8 py-8 max-w-7xl mx-auto">
            <div class="bg-brand-accent rounded-none p-8 md:p-12 flex flex-col md:flex-row justify-between items-center relative overflow-hidden group">
                <div class="z-10 relative w-full md:w-1/2">
                    <span class="bg-black text-white text-[10px] font-bold px-3 py-1 mb-4 inline-block uppercase tracking-widest">Design of the Day</span>
                    <h3 class="font-black text-4xl md:text-6xl text-brand-black mb-2 leading-none">BEWAKOOF<br>X NARUTO</h3>
                    <p class="text-brand-black/80 text-sm md:text-base mb-8 max-w-xs">Limited edition collaboration featuring exclusive artwork and premium fabrics.</p>
                    <button class="bg-black text-white px-8 py-3 rounded-none text-xs font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors">View Collection</button>
                </div>
                <div class="absolute right-0 bottom-0 md:top-0 w-full md:w-1/2 h-64 md:h-full opacity-20 md:opacity-100 transition-transform duration-500 group-hover:scale-105">
                     <img src="https://pngimg.com/uploads/naruto/naruto_PNG12.png" class="w-full h-full object-contain object-right-bottom">
                </div>
            </div>
        </section>

        <!-- Bestsellers Grid -->
        <section class="px-4 md:px-8 py-12 max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-8">
                <h3 class="font-black text-2xl md:text-3xl text-brand-black uppercase tracking-tight">Trending Now</h3>
                <a href="#" class="text-xs font-bold text-gray-400 hover:text-brand-black uppercase tracking-widest">View All</a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-8">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif
</div>
