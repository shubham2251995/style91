@if($recommendations->count() > 0)
<div class="py-8">
    <h2 class="text-2xl font-bold mb-6">
        @if($type === 'related')
            Related Products
        @elseif($type === 'similar')
            Similar Products
        @elseif($type === 'frequently_bought')
            Frequently Bought Together
        @elseif($type === 'personalized')
            Recommended For You
        @else
            Trending Products
        @endif
    </h2>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($recommendations as $recommendedProduct)
            <a href="{{ route('product', $recommendedProduct->slug) }}" class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-shadow group">
                <div class="aspect-square overflow-hidden bg-gray-100 relative">
                    @if($recommendedProduct->image_url)
                        <img src="{{ $recommendedProduct->image_url }}" alt="{{ $recommendedProduct->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                    @endif
                    
                    @if($recommendedProduct->stock_quantity <= 0)
                        <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                            Out of Stock
                        </div>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 line-clamp-2 mb-2">{{ $recommendedProduct->name }}</h3>
                    
                    @if($recommendedProduct->reviews_avg_rating)
                        <div class="flex items-center gap-1 mb-2">
                            <span class="text-yellow-400">⭐</span>
                            <span class="text-sm text-gray-600">{{ number_format($recommendedProduct->reviews_avg_rating, 1) }}</span>
                        </div>
                    @endif
                    
                    <div class="flex items-baseline gap-2">
                        <div class="text-xl font-bold text-gray-900">₹{{ number_format($recommendedProduct->price, 2) }}</div>
                        @if($recommendedProduct->compare_price && $recommendedProduct->compare_price > $recommendedProduct->price)
                            <div class="text-sm text-gray-500 line-through">₹{{ number_format($recommendedProduct->compare_price, 2) }}</div>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif
