<div class="min-h-screen bg-brand-gray">
    <!-- Search Header -->
    <div class="bg-white border-b-4 border-brand-accent sticky top-[104px] md:top-[120px] z-10 shadow-xl">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="relative">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search for style, products..."
                    class="w-full px-6 py-4 pl-14 pr-6 border-2 border-gray-200 rounded-xl font-medium text-lg focus:border-brand-black focus:ring-4 focus:ring-brand-accent/20 outline-none transition-all"
                >
                <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>

                <!-- Autocomplete Dropdown -->
                @if($showAutocomplete && count($autocompleteResults) > 0)
                <div class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-2xl border-2 border-brand-accent overflow-hidden z-20">
                    @foreach($autocompleteResults as $result)
                        <button wire:click="selectAutocomplete('{{ $result['slug'] }}')" class="w-full px-4 py-3 flex items-center gap-3 hover:bg-brand-accent/10 text-left transition-colors">
                            @if($result['image_url'])
                                <img src="{{ $result['image_url'] }}" class="w-14 h-14 object-cover rounded-lg shadow-md">
                            @else
                                <div class="w-14 h-14 bg-gray-200 rounded-lg"></div>
                            @endif
                            <div class="flex-1">
                                <div class="font-bold text-brand-black">{{ $result['name'] }}</div>
                                <div class="text-sm text-gray-600 font-medium">₹{{ number_format($result['price'], 2) }}</div>
                            </div>
                        </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Trending Searches -->
            @if(empty($search) && count($trendingSearches) > 0)
                <div class="mt-4">
                    <div class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Trending Searches:</div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($trendingSearches as $trending)
                            <button wire:click="$set('search', '{{ $trending }}')" class="px-4 py-2 bg-brand-black text-white rounded-full text-sm font-bold uppercase tracking-wide hover:bg-brand-accent hover:text-brand-black transition-all transform hover:scale-105">
                                {{ $trending }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="w-full md:w-72 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-[200px] border-2 border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-black text-xl uppercase tracking-tight">Filters</h3>
                        @if($category || !empty($tags) || $minPrice > 0 || $maxPrice < 10000 || $inStock || $minRating > 0)
                            <button wire:click="clearFilters" class="text-sm font-bold text-brand-accent hover:text-brand-black uppercase tracking-wide">Clear All</button>
                        @endif
                    </div>

                    <!-- Gender Filter -->
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-700 mb-3">Gender</label>
                        <div class="space-y-3">
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" wire:model.live="gender" value="" class="text-brand-accent focus:ring-brand-accent w-5 h-5">
                                <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-brand-black">All</span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" wire:model.live="gender" value="Men" class="text-brand-accent focus:ring-brand-accent w-5 h-5">
                                <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-brand-black">Men</span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" wire:model.live="gender" value="Women" class="text-brand-accent focus:ring-brand-accent w-5 h-5">
                                <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-brand-black">Women</span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" wire:model.live="gender" value="Unisex" class="text-brand-accent focus:ring-brand-accent w-5 h-5">
                                <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-brand-black">Unisex</span>
                            </label>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-700 mb-3">Category</label>
                        <select wire:model.live="category" class="w-full border-2 border-gray-200 rounded-lg text-sm font-medium py-2.5 px-3 focus:border-brand-black focus:ring-2 focus:ring-brand-accent/20 outline-none">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-700 mb-3">Price Range</label>
                        <div class="flex gap-3 items-center">
                            <input type="number" wire:model.live.debounce.500ms="minPrice" placeholder="Min" class="w-full border-2 border-gray-200 rounded-lg text-sm font-medium py-2.5 px-3 focus:border-brand-black focus:ring-2 focus:ring-brand-accent/20 outline-none">
                            <span class="font-bold text-gray-400">-</span>
                            <input type="number" wire:model.live.debounce.500ms="maxPrice" placeholder="Max" class="w-full border-2 border-gray-200 rounded-lg text-sm font-medium py-2.5 px-3 focus:border-brand-black focus:ring-2 focus:ring-brand-accent/20 outline-none">
                        </div>
                    </div>

                    <!-- Size Filter -->
                    @if(count($availableSizes) > 0)
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-700 mb-3">Size</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($availableSizes as $size)
                                <label class="cursor-pointer">
                                    <input type="checkbox" wire:model.live="selectedSizes" value="{{ $size }}" class="peer sr-only">
                                    <span class="px-4 py-2 border-2 rounded-lg text-sm font-bold uppercase tracking-wide peer-checked:bg-brand-black peer-checked:text-white peer-checked:border-brand-black hover:border-brand-accent transition-all">
                                        {{ $size }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Color Filter -->
                    @if(count($availableColors) > 0)
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-700 mb-3">Color</label>
                        <div class="space-y-3 max-h-48 overflow-y-auto">
                            @foreach($availableColors as $color)
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" wire:model.live="selectedColors" value="{{ $color }}" class="rounded text-brand-accent focus:ring-brand-accent w-5 h-5">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-brand-black">{{ $color }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Tags Filter -->
                    @if(count($allTags) > 0)
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-700 mb-3">Tags</label>
                        <div class="space-y-3 max-h-48 overflow-y-auto">
                            @foreach($allTags as $tag)
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" wire:model.live="tags" value="{{ $tag->id }}" class="rounded text-brand-accent focus:ring-brand-accent w-5 h-5">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-brand-black">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Stock Filter -->
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" wire:model.live="inStock" class="rounded text-brand-accent focus:ring-brand-accent w-5 h-5">
                            <span class="ml-3 text-sm font-bold text-gray-700 group-hover:text-brand-black">In Stock Only</span>
                        </label>
                    </div>

                    <!-- Rating Filter -->
                    <div class="mb-0">
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-700 mb-3">Minimum Rating</label>
                        <select wire:model.live="minRating" class="w-full border-2 border-gray-200 rounded-lg text-sm font-medium py-2.5 px-3 focus:border-brand-black focus:ring-2 focus:ring-brand-accent/20 outline-none">
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
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <p class="font-black text-xl text-brand-black">
                        {{ $products->total() }} {{ Str::plural('product', $products->total()) }} found
                    </p>
                    <select wire:model.live="sortBy" class="border-2 border-gray-200 rounded-lg text-sm font-medium py-2.5 px-4 focus:border-brand-black focus:ring-2 focus:ring-brand-accent/20 outline-none">
                        <option value="latest">Latest Drops</option>
                        <option value="popular">Most Popular</option>
                        <option value="rating">Highest Rated</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                    </select>
                </div>

                <!-- Products -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                        @foreach($products as $product)
                            <a href="{{ route('product', $product->slug) }}" class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02] group">
                                <div class="aspect-square overflow-hidden bg-gray-100 relative">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold">NO IMAGE</div>
                                    @endif
                                    
                                    <!-- Flash Sale Badge -->
                                    @if($product->activeFlashSale)
                                        <div class="absolute top-2 left-2 bg-gradient-to-r from-red-600 to-red-500 text-white text-[10px] font-black px-2.5 py-1 uppercase tracking-wider shadow-lg animate-pulse">
                                            SALE {{ $product->activeFlashSale->pivot->discount_percentage }}%
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-black text-brand-black line-clamp-2 mb-2 uppercase tracking-tight group-hover:text-brand-accent transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                    
                                    @if($product->reviews_count > 0)
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="text-yellow-400 text-lg">★</span>
                                            <span class="text-sm font-bold text-gray-700">
                                                {{ number_format($product->averageRating(), 1) }}
                                            </span>
                                            <span class="text-xs text-gray-500">({{ $product->reviewsCount() }})</span>
                                        </div>
                                    @endif

                                    <div class="text-xl font-black text-brand-black">
                                        ₹{{ number_format($product->price, 2) }}
                                    </div>
                                    
                                    @if($product->stock_quantity <= 0)
                                        <div class="mt-2 text-xs text-red-600 font-bold uppercase tracking-wide">Out of Stock</div>
                                    @elseif($product->stock_quantity < 10)
                                        <div class="mt-2 text-xs text-orange-600 font-bold uppercase tracking-wide">Only {{ $product->stock_quantity }} left!</div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-2xl shadow-xl p-16 text-center border-2 border-gray-100">
                        <svg class="w-32 h-32 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <h3 class="text-3xl font-black text-brand-black mb-3 uppercase tracking-tight">No Products Found</h3>
                        <p class="text-gray-600 mb-8 text-lg">We couldn't find any products matching your filters.</p>
                        <button wire:click="clearFilters" class="px-8 py-4 bg-brand-black text-white rounded-xl hover:bg-brand-accent hover:text-brand-black font-black uppercase tracking-wide transition-all transform hover:scale-105 shadow-lg">
                            Clear All Filters
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
