<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Product Comparison</h1>
            @if($compareProducts->count() > 0)
                <button wire:click="clearAll" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Clear All
                </button>
            @endif
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($compareProducts->count() > 0)
            <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="p-4 text-left font-bold sticky left-0 bg-white">Feature</th>
                            @foreach($compareProducts as $product)
                                <th class="p-4 min-w-64">
                                    <div class="relative">
                                        <button wire:click="removeFromCompare({{ $product->id }})" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full hover:bg-red-600 text-xs">
                                            ✕
                                        </button>
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover mx-auto mb-3 rounded">
                                        <div class="font-bold text-sm">{{ $product->name }}</div>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Price -->
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-medium sticky left-0 bg-white">Price</td>
                            @foreach($compareProducts as $product)
                                <td class="p-4 text-center">
                                    <div class="text-xl font-bold text-gray-900">₹{{ number_format($product->price, 2) }}</div>
                                    @if($product->compare_price && $product->compare_price > $product->price)
                                        <div class="text-sm text-gray-500 line-through">₹{{ number_format($product->compare_price, 2) }}</div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        <!-- Rating -->
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-medium sticky left-0 bg-white">Rating</td>
                            @foreach($compareProducts as $product)
                                <td class="p-4 text-center">
                                    @if($product->averageRating() > 0)
                                        <div class="flex items-center justify-center gap-1">
                                            <span class="text-yellow-400">⭐</span>
                                            <span>{{ number_format($product->averageRating(), 1) }}</span>
                                            <span class="text-sm text-gray-500">({{ $product->reviewsCount() }})</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400">No reviews</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        <!-- Stock -->
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-medium sticky left-0 bg-white">Availability</td>
                            @foreach($compareProducts as $product)
                                <td class="p-4 text-center">
                                    @if($product->stock_quantity > 0)
                                        <span class="text-green-600 font-medium">In Stock ({{ $product->stock_quantity }})</span>
                                    @else
                                        <span class="text-red-600 font-medium">Out of Stock</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        <!-- Category -->
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-medium sticky left-0 bg-white">Category</td>
                            @foreach($compareProducts as $product)
                                <td class="p-4 text-center">
                                    {{ $product->category->name ?? 'N/A' }}
                                </td>
                            @endforeach
                        </tr>

                        <!-- Description -->
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-medium sticky left-0 bg-white">Description</td>
                            @foreach($compareProducts as $product)
                                <td class="p-4">
                                    <div class="text-sm text-gray-600 line-clamp-3">{{ $product->description }}</div>
                                </td>
                            @endforeach
                        </tr>

                        <!-- Tags -->
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-medium sticky left-0 bg-white">Tags</td>
                            @foreach($compareProducts as $product)
                                <td class="p-4">
                                    <div class="flex flex-wrap gap-1 justify-center">
                                        @foreach($product->tags as $tag)
                                            <span class="px-2 py-1 bg-gray-100 text-xs rounded">{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                </td>
                            @endforeach
                        </tr>

                        <!-- Action -->
                        <tr>
                            <td class="p-4 font-medium sticky left-0 bg-white"></td>
                            @foreach($compareProducts as $product)
                                <td class="p-4 text-center">
                                    <div class="space-y-2">
                                        <a href="{{ route('product', $product->slug) }}" class="block w-full px-4 py-2 bg-brand-dark text-white rounded-lg hover:bg-brand-accent hover:text-brand-dark font-bold text-sm">
                                            View Details
                                        </a>
                                        @if($product->stock_quantity > 0)
                                            <button class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-bold text-sm">
                                                Add to Cart
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Products to Compare</h3>
                <p class="text-gray-500 mb-6">Add products to comparison from product pages</p>
                <a href="{{ route('search') }}" class="inline-block px-6 py-3 bg-brand-dark text-white rounded-lg hover:bg-brand-accent hover:text-brand-dark font-bold">
                    Browse Products
                </a>
            </div>
        @endif
    </div>
</div>
