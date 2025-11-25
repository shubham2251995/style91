<div class="min-h-screen bg-brand-gray p-6 pb-24">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold tracking-tighter mb-8 text-brand-dark">
            MY <span class="text-brand-accent">WISHLIST</span>
        </h1>

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4 mb-6 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        @if($wishlistItems->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($wishlistItems as $item)
                <div class="bg-white rounded-xl overflow-hidden shadow-sm relative group">
                    <!-- Remove Button -->
                    <button 
                        wire:click="removeFromWishlist({{ $item->product->id }})"
                        class="absolute top-2 right-2 z-10 bg-white/90 p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Product Image -->
                    <a href="{{ route('product', $item->product->slug) }}" class="block">
                        <img src="{{ $item->product->image_url }}" class="w-full aspect-square object-cover" alt="{{ $item->product->name }}">
                    </a>

                    <!-- Product Details -->
                    <div class="p-4">
                        <a href="{{ route('product', $item->product->slug) }}" class="block">
                            <h3 class="font-bold text-lg text-brand-dark mb-1 hover:text-brand-accent transition">{{ $item->product->name }}</h3>
                        </a>
                        <p class="text-xl font-bold text-brand-dark mb-4">${{ number_format($item->product->price, 2) }}</p>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <button 
                                wire:click="moveToCart({{ $item->product->id }})"
                                class="flex-1 bg-brand-dark text-white font-bold py-2 rounded-lg hover:bg-opacity-90 transition text-sm"
                            >
                                ADD TO CART
                            </button>
                            <a 
                                href="{{ route('product', $item->product->slug) }}"
                                class="flex-1 bg-gray-200 text-brand-dark font-bold py-2 rounded-lg hover:bg-gray-300 transition text-sm text-center"
                            >
                                VIEW
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="bg-gray-100 p-8 rounded-full mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-2 text-brand-dark">YOUR WISHLIST IS EMPTY</h3>
                <p class="text-gray-500 mb-8 max-w-md">Start adding your favorite items to build your dream collection.</p>
                <a href="{{ route('home') }}" class="bg-brand-accent text-brand-dark px-8 py-3 rounded-xl font-bold hover:bg-yellow-400 transition shadow-lg">
                    EXPLORE PRODUCTS
                </a>
            </div>
        @endif
    </div>
</div>
