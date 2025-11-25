<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Wishlist</h1>
            @if($wishlists->count() > 0)
                <button wire:click="shareWishlist" class="px-4 py-2 bg-brand-dark text-white rounded-lg hover:bg-brand-accent hover:text-brand-dark font-bold">
                    🔗 Share Wishlist
                </button>
            @endif
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('message') }}
            </div>
        @endif

        @if($wishlists->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                @foreach($wishlists as $wishlist)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden group hover:shadow-lg transition-shadow">
                        <!-- Product Image -->
                        <div class="relative aspect-square overflow-hidden bg-gray-100">
                            @if($wishlist->product->image_url)
                                <img src="{{ $wishlist->product->image_url }}" alt="{{ $wishlist->product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    No Image
                                </div>
                            @endif
                            
                            <!-- Remove button -->
                            <button wire:click="removeFromWishlist({{ $wishlist->product_id }})" class="absolute top-2 right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-red-50 transition-colors">
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <!-- Stock badge -->
                            @if($wishlist->product->stock_quantity <= 0)
                                <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    Out of Stock
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <a href="{{ route('product.show', $wishlist->product->slug) }}" class="font-bold text-gray-900 hover:text-brand-accent line-clamp-2 mb-2">
                                {{ $wishlist->product->name }}
                            </a>
                            <div class="text-xl font-bold text-gray-900 mb-3">
                                ₹{{ number_format($wishlist->product->price, 2) }}
                            </div>

                            <!-- Actions -->
                            <div class="space-y-2">
                                @if($wishlist->product->stock_quantity > 0)
                                    <button wire:click="moveToCart({{ $wishlist->product_id }})" class="w-full px-4 py-2 bg-brand-dark text-white rounded-lg hover:bg-brand-accent hover:text-brand-dark font-bold text-sm">
                                        Add to Cart
                                    </button>
                                @else
                                    <button wire:click="openAlertModal({{ $wishlist->product_id }})" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold text-sm">
                                        🔔 Notify Me
                                    </button>
                                @endif
                                
                                <button wire:click="openAlertModal({{ $wishlist->product_id }})" class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-bold text-sm">
                                    💰 Price Alert
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($wishlists->hasPages())
                <div class="mt-6">
                    {{ $wishlists->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Your Wishlist is Empty</h3>
                <p class="text-gray-500 mb-6">Start adding products you love!</p>
                <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-brand-dark text-white rounded-lg hover:bg-brand-accent hover:text-brand-dark font-bold">
                    Browse Products
                </a>
            </div>
        @endif

        <!-- Alert Modal -->
        @if($showAlertModal)
        <div class="fixed z-50 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Set Alert</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alert Type</label>
                                <select wire:model.live="alertType" class="w-full border-gray-300 rounded-lg">
                                    <option value="price_drop">Price Drop</option>
                                    <option value="back_in_stock">Back in Stock</option>
                                </select>
                            </div>

                            @if($alertType === 'price_drop')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Notify me when price drops below</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">₹</span>
                                        <input type="number" step="0.01" wire:model="thresholdPrice" class="w-full border-gray-300 rounded-lg pl-8" placeholder="0.00">
                                    </div>
                                    @error('thresholdPrice') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button wire:click="setAlert" class="w-full sm:w-auto px-4 py-2 bg-brand-dark text-white rounded-lg hover:bg-brand-accent hover:text-brand-dark font-bold">
                            Set Alert
                        </button>
                        <button wire:click="closeAlertModal" class="w-full sm:w-auto px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 mt-2 sm:mt-0">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('copyToClipboard', event => {
        navigator.clipboard.writeText(event.detail.url);
    });
</script>
