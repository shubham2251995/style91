@if($products->count() > 0)
<div class="py-8">
    <h2 class="text-2xl font-bold mb-6">Recently Viewed</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($products as $product)
            <a href="{{ route('product', $product->slug) }}" class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-shadow group">
                <div class="aspect-square overflow-hidden bg-gray-100">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 line-clamp-2 mb-2">{{ $product->name }}</h3>
                    <div class="text-xl font-bold text-gray-900">₹{{ number_format($product->price, 2) }}</div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif
