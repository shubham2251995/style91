<div class="min-h-screen bg-brand-gray pb-24">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-2 text-brand-dark">NEW <span class="text-brand-accent">ARRIVALS</span></h1>
        <p class="text-gray-600 mb-8">Check out our latest drops</p>

        @if($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
                @foreach($products as $product)
                <div class="relative group">
                    <!-- Wishlist Button -->
                    <div class="absolute top-2 right-2 z-10">
                        <livewire:wishlist-button :productId="$product->id" :key="'wishlist-'.$product->id" />
                    </div>

                    <!-- NEW Badge -->
                    <div class="absolute top-2 left-2 z-10">
                        <span class="bg-brand-accent text-brand-dark text-xs font-bold px-2 py-1 rounded">NEW</span>
                    </div>

                    <!-- Product Image -->
                    <a href="{{ route('product', $product->slug) }}" class="block">
                        <div class="aspect-[3/4] rounded-2xl overflow-hidden mb-3 bg-gray-100 relative">
                            <img src="{{ $product->image_url }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                 alt="{{ $product->name }}">
                        </div>
                        <h4 class="font-bold text-sm leading-tight mb-1">{{ $product->name }}</h4>
                        <p class="text-brand-accent font-mono text-sm font-bold mb-3">${{ number_format($product->price, 2) }}</p>
                    </a>

                    <!-- Quick Add Button -->
                    <livewire:quick-add-to-cart :productId="$product->id" :key="'cart-'.$product->id" />
                </div>
                @endforeach
            </div>

            {{ $products->links() }}
        @else
            <div class="text-center py-20">
                <p class="text-gray-500 text-lg">No new arrivals yet. Check back soon!</p>
            </div>
        @endif
    </div>
</div>
