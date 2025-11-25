@props(['content', 'title'])

@php
use App\Models\Product;

$limit = $content['limit'] ?? 4;
$filter = $content['product_filter'] ?? 'latest';

$products = match($filter) {
    'featured' => Product::where('is_featured', true)->take($limit)->get(),
    'sale' => Product::where('on_sale', true)->take($limit)->get(),
    default => Product::latest()->take($limit)->get(),
};
@endphp

<section class="px-4">
    @if($title)
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-brand-dark">{{ $title }}</h3>
            @if(isset($content['view_all_url']))
@props(['content', 'title'])

@php
use App\Models\Product;

$limit = $content['limit'] ?? 4;
$filter = $content['product_filter'] ?? 'latest';

$products = match($filter) {
    'featured' => Product::where('is_featured', true)->take($limit)->get(),
    'sale' => Product::where('on_sale', true)->take($limit)->get(),
    default => Product::latest()->take($limit)->get(),
};
@endphp

<section class="px-4">
    @if($title)
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-brand-dark">{{ $title }}</h3>
            @if(isset($content['view_all_url']))
                <a href="{{ $content['view_all_url'] }}" class="text-sm text-brand-accent hover:underline">View All →</a>
            @endif
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="group block">
                <a href="{{ route('products.show', $product->slug) }}" class="block relative overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="aspect-w-1 aspect-h-1 w-full">
                        <img src="{{ $product->image_url }}" loading="lazy" alt="{{ $product->name }}" class="w-full h-full object-cover" />
                    </div>
                    @if($product->on_sale)
                        <span class="absolute top-2 left-2 bg-brand-accent text-white text-xs font-bold px-2 py-1 rounded">Sale</span>
                    @endif
                </a>
                <div class="mt-3">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <h4 class="font-bold text-sm leading-tight mb-1 text-brand-dark group-hover:text-brand-accent transition-colors">{{ $product->name }}</h4>
                        <p class="text-brand-accent font-mono text-sm font-bold mb-3">${{ number_format($product->price, 2) }}</p>
                    </a>

                    <!-- Add to Cart Button -->
                    <livewire:quick-add-to-cart :productId="$product->id" :key="'cart-'.$product->id" />
                </div>
            </div>
        @endforeach
    </div>
</section>
