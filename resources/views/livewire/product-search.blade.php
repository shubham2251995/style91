<div class="min-h-screen bg-brand-gray pb-24" x-data="{ showFilters: false }">
    <!-- Search Bar & Filter Toggle -->
    <div class="bg-white border-b border-gray-200 p-4 sticky top-14 md:top-16 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto">
            <div class="flex gap-3">
                <div class="flex-1 relative">
                    <input 
                        wire:model.live.debounce.300ms="search"
                        type="text" 
                        placeholder="Search for drops, gear, etc..."
                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border-0 rounded-xl focus:ring-2 focus:ring-brand-accent font-medium placeholder-gray-400"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <button @click="showFilters = !showFilters" class="lg:hidden px-4 py-3 bg-brand-black text-white rounded-xl font-bold text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                    <span class="hidden sm:inline">Filters</span>
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 mt-6">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar (Desktop: Sticky, Mobile: Drawer) -->
            <div class="lg:w-64 flex-shrink-0 z-40"
                 :class="{'fixed inset-0 bg-black/50 lg:static lg:bg-transparent': showFilters, 'hidden lg:block': !showFilters}"
                 x-show="showFilters || window.innerWidth >= 1024"
                 x-transition.opacity.duration.200ms>
                
                <div class="bg-white lg:rounded-xl p-6 space-y-8 h-full lg:h-auto lg:sticky lg:top-32 w-3/4 lg:w-full ml-auto lg:ml-0 shadow-2xl lg:shadow-none overflow-y-auto"
                     @click.away="showFilters = false">
                    
                    <div class="flex justify-between items-center lg:hidden mb-4">
                        <h3 class="font-black text-xl text-brand-black">FILTERS</h3>
                        <button @click="showFilters = false" class="text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Category</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" wire:model.live="category" value="" class="text-brand-accent focus:ring-brand-accent">
                                <span class="text-sm font-medium group-hover:text-brand-accent transition-colors">All Categories</span>
                            </label>
                            @foreach($categories as $cat)
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" wire:model.live="category" value="{{ $cat }}" class="text-brand-accent focus:ring-brand-accent">
                                    <span class="text-sm font-medium group-hover:text-brand-accent transition-colors">{{ ucfirst($cat) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Price Range</label>
                        <div class="flex gap-2">
                            <input wire:model.live.debounce.500ms="minPrice" type="number" placeholder="Min" class="w-full bg-gray-50 border-0 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-brand-accent">
                            <input wire:model.live.debounce.500ms="maxPrice" type="number" placeholder="Max" class="w-full bg-gray-50 border-0 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-brand-accent">
                        </div>
                    </div>

                    <!-- In Stock -->
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <div class="relative inline-flex items-center">
                                <input wire:model.live="inStock" type="checkbox" class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-accent"></div>
                            </div>
                            <span class="text-sm font-bold text-brand-black">In Stock Only</span>
                        </label>
                    </div>

                    <!-- Sort By -->
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Sort By</label>
                        <select wire:model.live="sortBy" class="w-full bg-gray-50 border-0 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-brand-accent cursor-pointer">
                            <option value="newest">Newest Drops</option>
                            <option value="best_sellers">Best Sellers</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="name">Name (A-Z)</option>
                        </select>
                    </div>
                    
                    <button wire:click="clearFilters" class="w-full py-2 text-xs font-bold text-red-500 hover:text-red-600 uppercase tracking-widest border border-red-100 rounded-lg hover:bg-red-50 transition-colors">
                        Reset Filters
                    </button>
                </div>
            </div>

            <!-- Loading overlay -->
            <div wire:loading class="fixed inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center z-50">
                <div class="flex flex-col items-center">
                    <div class="animate-spin rounded-full h-10 w-10 border-4 border-brand-accent border-t-transparent"></div>
                    <p class="mt-4 text-xs font-black uppercase tracking-widest text-brand-black">Loading Drops...</p>
                </div>
            </div>

            <div class="flex-1">
                @if($products->count() > 0)
                    <div class="flex justify-between items-center mb-6">
                        <p class="text-sm font-medium text-gray-500">
                            Showing <span class="text-brand-black font-bold">{{ $products->count() }}</span> results
                        </p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 gap-y-8">
                        @foreach($products as $product)
                        <a href="{{ route('product', $product->slug) }}" class="group block">
                            <div class="relative aspect-[4/5] overflow-hidden bg-gray-100 rounded-lg mb-3">
                                <img src="{{ $product->image_url }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="{{ $product->name }}">
                                
                                @if($product->stock_quantity <= 0)
                                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
                                        <span class="text-white font-black text-xs uppercase tracking-widest border border-white px-3 py-1">Sold Out</span>
                                    </div>
                                @elseif($product->created_at->diffInDays(now()) < 7)
                                    <div class="absolute top-2 left-2">
                                        <span class="bg-brand-accent text-brand-black text-[10px] font-bold px-2 py-1 uppercase tracking-wider rounded-sm">New</span>
                                    </div>
                                @endif
                                
                                <div class="absolute bottom-0 left-0 w-full p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                    <button class="w-full bg-white text-brand-black text-xs font-bold py-2 rounded shadow-lg uppercase tracking-wider hover:bg-brand-black hover:text-white transition-colors">
                                        Quick View
                                    </button>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-brand-black truncate group-hover:text-brand-accent transition-colors">{{ $product->name }}</h3>
                                <p class="text-xs text-gray-500 mb-1">{{ ucfirst($product->category) }}</p>
                                <p class="text-sm font-black text-brand-black">₹{{ number_format($product->price * 80) }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
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
                        <h3 class="text-2xl font-black mb-2 text-brand-black uppercase tracking-tight">No Drops Found</h3>
                        <p class="text-gray-500 mb-8 max-w-xs mx-auto">We couldn't find what you're looking for. Try adjusting your filters.</p>
                        <button wire:click="clearFilters" class="bg-brand-black text-white px-8 py-3 rounded-xl font-bold text-sm uppercase tracking-widest hover:bg-brand-accent hover:text-brand-black transition-all">
                            Clear All Filters
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
