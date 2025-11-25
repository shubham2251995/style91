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
        
        <!-- Hero Section (Slider Style) -->
        <section class="relative w-full overflow-hidden">
            <div class="flex overflow-x-auto snap-x snap-mandatory scrollbar-hide">
                <div class="snap-center shrink-0 w-full relative aspect-[4/5] md:aspect-[21/9]">
                    <img src="https://images.unsplash.com/photo-1523396870179-16bed9562000?q=80&w=2000&auto=format&fit=crop" 
                         class="w-full h-full object-cover" 
                         alt="Hero 1">
                    <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/80 to-transparent p-6">
                        <h2 class="text-brand-accent font-black text-3xl mb-2">MEN'S FASHION</h2>
                        <p class="text-white text-sm mb-4">Up to 60% Off on Streetwear</p>
                        <button class="bg-brand-accent text-brand-dark px-6 py-2 rounded font-bold text-sm uppercase">Shop Now</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Grid (Circle) -->
        <section class="px-4">
            <h3 class="font-bold text-lg mb-4 text-brand-dark">Categories</h3>
            <div class="grid grid-cols-4 gap-4">
                @foreach(['T-Shirts', 'Joggers', 'Hoodies', 'Accessories', 'New', 'Best', 'Sale', 'Custom'] as $cat)
                <div class="flex flex-col items-center gap-2">
                    <div class="w-16 h-16 rounded-full bg-white border-2 border-brand-accent p-1">
                        <div class="w-full h-full rounded-full bg-gray-200 overflow-hidden">
                            <img src="https://source.unsplash.com/random/100x100/?fashion,{{ $cat }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <span class="text-xs font-bold text-brand-dark">{{ $cat }}</span>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Design of the Day -->
        <section class="px-4">
            <div class="bg-brand-accent rounded-xl p-6 flex justify-between items-center relative overflow-hidden">
                <div class="z-10">
                    <span class="bg-white text-brand-dark text-[10px] font-bold px-2 py-1 rounded mb-2 inline-block">DESIGN OF THE DAY</span>
                    <h3 class="font-black text-2xl text-brand-dark mb-1">BEWAKOOF<br>X NARUTO</h3>
                    <p class="text-brand-dark/80 text-xs mb-4">Limited Edition Drop</p>
                    <button class="bg-brand-dark text-white px-4 py-2 rounded text-xs font-bold">VIEW COLLECTION</button>
                </div>
                <img src="https://pngimg.com/uploads/naruto/naruto_PNG12.png" class="absolute right-0 bottom-0 w-32 h-32 object-contain drop-shadow-xl">
            </div>
        </section>

        <!-- Product Grid -->
        <section class="px-4">
            <h3 class="font-bold text-lg mb-4 text-brand-dark">Bestsellers</h3>
            <div class="grid grid-cols-2 gap-4">
                @foreach($products as $product)
                <a href="{{ route('product', $product->slug) }}" class="bg-white rounded-lg overflow-hidden shadow-sm">
                    <div class="relative aspect-[3/4]">
                        <img src="{{ $product->image_url }}" class="w-full h-full object-cover">
                        <div class="absolute bottom-2 left-2 bg-white/90 px-2 py-0.5 rounded text-[10px] font-bold text-brand-dark">
                            4.5 ★
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="font-bold text-sm text-brand-dark truncate">{{ $product->name }}</h3>
                        <p class="text-xs text-gray-500 mb-2">Men's T-Shirt</p>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-brand-dark">₹{{ $product->price * 80 }}</span>
                            <span class="text-xs text-gray-400 line-through">₹{{ ($product->price * 80) + 200 }}</span>
                            <span class="text-[10px] text-green-600 font-bold">50% OFF</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
