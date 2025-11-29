@props(['content', 'title'])

@php
use App\Models\Product;

$limit = $content['limit'] ?? 4;
$filter = $content['product_filter'] ?? 'latest';

$products = match($filter) {
    'featured' => Product::with(['variantOptions'])->where('is_featured', true)->take($limit)->get(),
    'sale' => Product::with(['variantOptions'])->where('on_sale', true)->take($limit)->get(),
    default => Product::with(['variantOptions'])->latest()->take($limit)->get(),
};
@endphp

<section class="px-4 md:px-8 py-12 max-w-7xl mx-auto">
    @if($title)
        <div class="flex justify-between items-end mb-8">
            <h3 class="font-black text-2xl md:text-3xl text-brand-black uppercase tracking-tight">{{ $title }}</h3>
            @if(isset($content['view_all_url']))
                <a href="{{ $content['view_all_url'] }}" class="text-xs font-bold text-gray-400 hover:text-brand-black uppercase tracking-widest">View All</a>
            @endif
        </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-8">
        @foreach($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</section>
