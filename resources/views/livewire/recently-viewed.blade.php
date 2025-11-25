@if($products->count() > 0)
<div class="mb-8">
    <h3 class="font-bold text-lg mb-4 text-brand-dark">Recently Viewed</h3>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($products as $product)
        <a href="{{ route('product', $product->slug) }}" class="group block">
            <div class="aspect-square rounded-lg overflow-hidden mb-2 bg-gray-100">
                <img src="{{ $product->image_url }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition" 
                     alt="{{ $product->name }}">
            </div>
            <h4 class="font-bold text-xs leading-tight mb-1 truncate">{{ $product->name }}</h4>
            <p class="text-brand-accent text-xs font-bold">${{ number_format($product->price, 2) }}</p>
        </a>
        @endforeach
    </div>
</div>
@endif
