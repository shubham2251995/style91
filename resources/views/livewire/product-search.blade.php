<div class="min-h-screen bg-brand-gray pb-24">
    <!-- Search Bar -->
    <div class="bg-white border-b border-gray-200 p-4 sticky top-14 md:top-16 z-40">
        <div class="max-w-7xl mx-auto">
            <div class="flex gap-2">
                <div class="flex-1 relative">
                    <input 
                        wire:model.live.debounce.300ms="search"
                        type="text" 
                        placeholder="Search products..."
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-accent"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="{1.5}" stroke="currentColor" class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <button wire:click="clearFilters" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold text-sm hover:bg-gray-200 transition">
                    Clear
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 mt-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Filters Sidebar -->
            <div class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-xl p-6 space-y-6 sticky top-32">
                    <h3 class="font-bold text-lg text-brand-dark">Filters</h3>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                        <select wire:model.live="category" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Price Range</label>
                        <div class="flex gap-2">
                            <input wire:model.live.debounce.500ms="minPrice" type="number" placeholder="Min" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <input wire:model.live.debounce.500ms="maxPrice" type="number" placeholder="Max" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                    </div>

                    <!-- In Stock -->
                    <div>
                        <label class="flex items-center gap-2">
                            <input wire:model.live="inStock" type="checkbox" class="rounded border-gray-300 text-brand-accent focus:ring-brand-accent">
                            <span class="text-sm font-bold text-gray-700">In Stock Only</span>
                        </label>
                    </div>

                    <!-- Sort By -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Sort By</label>
                        <select wire:model.live="sortBy" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option value="newest">Newest First</option>
                            <option value="best_sellers">Best Sellers</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="name">Name (A-Z)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Loading overlay -->
<div wire:loading class="fixed inset-0 bg-black/30 flex items-center justify-center z-50">
    <div class="bg-white p-4 rounded shadow-lg">
        <div class="animate-spin rounded-full h-8 w-8 border-4 border-brand-accent border-t-transparent"></div>
        <p class="mt-2 text-sm">Searching products...</p>
    </div>
</div>
            <div class="flex-1">
                @if($products->count() > 0)
                    <div class="mb-4 text-sm text-gray-600">
                        Showing {{ $products->count() }} of {{ $products->total() }} results
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($products as $product)
                        <a href="{{ route('product', $product->slug) }}" class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition group">
                            <div class="relative aspect-square">
                                <img src="{{ $product->image_url }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" alt="{{ $product->name }}">
                                @if($product->stock_quantity <= 0)
                                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">OUT OF STOCK</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="font-bold text-sm text-brand-dark truncate mb-1">{{ $product->name }}</h3>
                                <p class="text-xs text-gray-500 mb-2">{{ ucfirst($product->category) }}</p>
                                <p class="text-lg font-bold text-brand-dark">${{ number_format($product->price, 2) }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <!-- No Results -->
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="bg-gray-100 p-8 rounded-full mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2 text-brand-dark">NO PRODUCTS FOUND</h3>
                        <p class="text-gray-500 mb-8">Try adjusting your filters or search query.</p>
                        <button wire:click="clearFilters" class="bg-brand-accent text-brand-dark px-8 py-3 rounded-xl font-bold hover:bg-yellow-400 transition">
                            CLEAR FILTERS
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
