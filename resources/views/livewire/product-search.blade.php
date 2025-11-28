<div class="min-h-screen bg-gray-50">
    <!-- Search Header -->
    <div class="bg-white border-b sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="relative">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search products..."
                    class="w-full px-4 py-3 pl-12 pr-4 border-2 border-gray-200 rounded-xl focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20"
                >
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>

                <!-- Autocomplete Dropdown -->
                @if($showAutocomplete && count($autocompleteResults) > 0)
                <div class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl border overflow-hidden z-20">
                    @foreach($autocompleteResults as $result)
                        <button wire:click="selectAutocomplete('{{ $result['slug'] }}')" class="w-full px-4 py-3 flex items-center gap-3 hover:bg-gray-50 text-left">
                            @if($result['image_url'])
                                <img src="{{ $result['image_url'] }}" class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded"></div>
                            @endif
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">{{ $result['name'] }}</div>
                                <div class="text-sm text-gray-600">₹{{ number_format($result['price'], 2) }}</div>
                            </div>
                        </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Trending Searches -->
            @if(empty($search) && count($trendingSearches) > 0)
                <div class="mt-3">
                    <div class="text-xs text-gray-500 mb-2">Trending:</div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($trendingSearches as $trending)
                            <button wire:click="$set('search', '{{ $trending }}')" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200">
                                {{ $trending }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Filters Sidebar -->
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg">Filters</h3>
                        @if($category || !empty($tags) || $minPrice > 0 || $maxPrice < 10000 || $inStock || $minRating > 0)
                            <button wire:click="clearFilters" class="text-sm text-blue-600 hover:text-blue-800">Clear</button>
                        @endif
                    </div>

                    <!-- Gender Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" wire:model.live="gender" value="" class="text-brand-accent focus:ring-brand-accent">
                                <span class="ml-2 text-sm text-gray-700">All</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model.live="gender" value="Men" class="text-brand-accent focus:ring-brand-accent">
                                <span class="ml-2 text-sm text-gray-700">Men</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model.live="gender" value="Women" class="text-brand-accent focus:ring-brand-accent">
                                <span class="ml-2 text-sm text-gray-700">Women</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model.live="gender" value="Unisex" class="text-brand-accent focus:ring-brand-accent">
                                <span class="ml-2 text-sm text-gray-700">Unisex</span>
                            </label>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select wire:model.live="category" class="w-full border-gray-300 rounded-lg text-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                        <div class="flex gap-2 items-center">
                            <input type="number" wire:model.live.debounce.500ms="minPrice" placeholder="Min" class="w-full border-gray-300 rounded-lg text-sm">
                            <span>-</span>
                            <input type="number" wire:model.live.debounce.500ms="maxPrice" placeholder="Max" class="w-full border-gray-300 rounded-lg text-sm">
                        </div>
                    </div>

                    <!-- Size Filter -->
                    @if(count($availableSizes) > 0)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($availableSizes as $size)
                                <label class="cursor-pointer">
                                    <input type="checkbox" wire:model.live="selectedSizes" value="{{ $size }}" class="peer sr-only">
                                    <span class="px-3 py-1 border rounded text-sm peer-checked:bg-brand-black peer-checked:text-white peer-checked:border-brand-black hover:border-gray-400 transition-colors">
                                        {{ $size }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Color Filter -->
                    @if(count($availableColors) > 0)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                        <div class="space-y-2 max-h-40 overflow-y-auto">
                            @foreach($availableColors as $color)
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model.live="selectedColors" value="{{ $color }}" class="rounded text-brand-accent focus:ring-brand-accent">
                                    <span class="ml-2 text-sm text-gray-700">{{ $color }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Tags Filter -->
                    @if(count($allTags) > 0)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                        <div class="space-y-2 max-h-40 overflow-y-auto">
                            @foreach($allTags as $tag)
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model.live="tags" value="{{ $tag->id }}" class="rounded">
                                    <span class="ml-2 text-sm text-gray-700">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Stock Filter -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.live="inStock" class="rounded">
                            <span class="ml-2 text-sm text-gray-700">In Stock Only</span>
                        </label>
                    </div>

                    <!-- Rating Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Rating</label>
                        <select wire:model.live="minRating" class="w-full border-gray-300 rounded-lg text-sm">
                            <option value="0">All Ratings</option>
                            <option value="4">4★ & above</option>
                            <option value="3">3★ & above</option>
                            <option value="2">2★ & above</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1">
                <!-- Sort & Results Count -->
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-600">{{ $products->total() }} {{ Str::plural('product', $products->total()) }} found</p>
                    <select wire:model.live="sortBy" class="border-gray-300 rounded-lg text-sm">
                        <option value="latest">Latest</option>
                        <option value="popular">Most Popular</option>
                        <option value="rating">Highest Rated</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                    </select>
                </div>

                <!-- Products -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
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
                                    
                                    @if($product->reviews_count > 0)
                                        <div class="flex items-center gap-1 mb-2">
                                            <span class="text-yellow-400">⭐</span>
                                            <span class="text-sm text-gray-600">{{ number_format($product->averageRating(), 1) }} ({{ $product->reviewsCount() }})</span>
                                        </div>
                                    @endif

                                    <div class="text-xl font-bold text-gray-900">₹{{ number_format($product->price, 2) }}</div>
                                    
                                    @if($product->stock_quantity <= 0)
                                        <div class="mt-2 text-xs text-red-600 font-medium">Out of Stock</div>
                                    @elseif($product->stock_quantity < 10)
                                        <div class="mt-2 text-xs text-orange-600 font-medium">Only {{ $product->stock_quantity }} left</div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    {{ $products->links() }}
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                        <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">No products found</h3>
                        <p class="text-gray-500 mb-6">Try adjusting your filters or search terms</p>
                        <button wire:click="clearFilters" class="px-6 py-3 bg-brand-dark text-white rounded-lg hover:bg-brand-accent hover:text-brand-dark font-bold">
                            Clear All Filters
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
