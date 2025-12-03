@props(['content', 'title'])

@php
use App\Models\Product;

$limit = $content['limit'] ?? 8;
$filter = $content['product_filter'] ?? 'latest';

$products = match($filter) {
    'featured' => Product::with(['variantOptions'])->where('is_featured', true)->take($limit)->get(),
    'sale' => Product::with(['variantOptions'])->where('on_sale', true)->take($limit)->get(),
    default => Product::with(['variantOptions'])->latest()->take($limit)->get(),
};
@endphp

<section class="w-full max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-12 md:py-16">
    @if($title)
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 md:mb-12 gap-4">
            <div>
                <h2 class="font-black text-3xl md:text-4xl lg:text-5xl text-brand-black uppercase tracking-tighter mb-2">
                    {{ $title }}
                </h2>
                <div class="w-20 h-1 bg-brand-accent"></div>
            </div>
            @if(isset($content['view_all_url']))
                <a href="{{ $content['view_all_url'] }}" 
                   class="inline-flex items-center gap-2 text-sm font-black text-gray-600 hover:text-brand-black uppercase tracking-widest transition-colors group">
                    <span>View All</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            @endif
        </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        @foreach($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</section>
