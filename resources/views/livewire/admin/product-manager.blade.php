<div class="p-6 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Product Manager</h2>
            <button wire:click="create" class="bg-brand-accent text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors font-bold shadow-lg shadow-blue-900/20">
                + Add Product
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500/50 text-green-400 px-4 py-3 rounded-xl relative mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white/5 border border-white/10 rounded-xl p-4 mb-6 backdrop-blur-sm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Search products..." class="w-full bg-black/20 border-white/10 text-white placeholder-gray-500 rounded-lg px-3 py-2 text-sm focus:ring-brand-accent focus:border-brand-accent">
                </div>
                <div>
                    <select wire:model.live="filterCategory" class="w-full bg-black/20 border-white/10 text-white rounded-lg px-3 py-2 text-sm focus:ring-brand-accent focus:border-brand-accent">
                        <option value="" class="bg-gray-900">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" class="bg-gray-900">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select wire:model.live="filterStock" class="w-full bg-black/20 border-white/10 text-white rounded-lg px-3 py-2 text-sm focus:ring-brand-accent focus:border-brand-accent">
                        <option value="" class="bg-gray-900">All Stock</option>
                        <option value="in" class="bg-gray-900">In Stock</option>
                        <option value="low" class="bg-gray-900">Low Stock (&lt;10)</option>
                        <option value="out" class="bg-gray-900">Out of Stock</option>
                    </select>
                </div>
                <div>
                    <button wire:click="$set('searchTerm', ''); $set('filterCategory', ''); $set('filterStock', '')" class="w-full bg-white/5 text-gray-300 border border-white/10 px-3 py-2 rounded-lg text-sm hover:bg-white/10 transition-colors">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden backdrop-blur-sm">
            <table class="min-w-full divide-y divide-white/5">
                <thead class="bg-white/5">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tags</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($products as $product)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover mr-3 border border-white/10">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-white/5 border border-white/10 mr-3 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-bold text-white">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-500">/{{ $product->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $product->category?->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-white">
                                ₹{{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-md 
                                    {{ $product->stock_quantity > 10 ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 
                                      ($product->stock_quantity > 0 ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20' : 
                                      'bg-red-500/10 text-red-400 border border-red-500/20') }}">
                                    {{ $product->stock_quantity }} units
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($product->tags as $tag)
                                        <span class="px-2 py-1 text-xs rounded-md text-white border border-white/10" style="background-color: {{ $tag->color }}40;">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $product->id }})" class="text-brand-accent hover:text-blue-400 mr-3 transition-colors">Edit</button>
                                <button wire:click="duplicate({{ $product->id }})" class="text-gray-400 hover:text-white mr-3 transition-colors">Duplicate</button>
                                <button wire:click="delete({{ $product->id }})" class="text-red-400 hover:text-red-300 transition-colors" onclick="confirm('Delete this product?') || event.stopImmediatePropagation()">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <p class="text-lg font-medium text-gray-400">No products found</p>
                                    <p class="text-sm text-gray-600">Add your first product to get started</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-white/10">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

        <!-- Modal -->
        @if($isModalOpen)
        <div class="fixed z-50 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-black/80 transition-opacity backdrop-blur-sm"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-gray-900 border border-white/10 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-xl leading-6 font-bold text-white mb-6">
                            {{ $productId ? 'Edit Product' : 'Create Product' }}
                        </h3>
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Product Name *</label>
                                    <input type="text" wire:model.live="name" class="block w-full bg-black/20 border-white/10 rounded-lg shadow-sm text-white focus:ring-brand-accent focus:border-brand-accent sm:text-sm">
                                    @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Slug *</label>
                                    <input type="text" wire:model="slug" class="block w-full bg-black/20 border-white/10 rounded-lg shadow-sm text-white focus:ring-brand-accent focus:border-brand-accent sm:text-sm">
                                    @error('slug') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Description</label>
                                <textarea wire:model="description" rows="4" class="block w-full bg-black/20 border-white/10 rounded-lg shadow-sm text-white focus:ring-brand-accent focus:border-brand-accent sm:text-sm"></textarea>
                            </div>

                            <div class="grid grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Price (₹) *</label>
                                    <input type="number" step="0.01" wire:model="price" class="block w-full bg-black/20 border-white/10 rounded-lg shadow-sm text-white focus:ring-brand-accent focus:border-brand-accent sm:text-sm">
                                    @error('price') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Stock Quantity *</label>
                                    <input type="number" wire:model="stock_quantity" class="block w-full bg-black/20 border-white/10 rounded-lg shadow-sm text-white focus:ring-brand-accent focus:border-brand-accent sm:text-sm">
                                    @error('stock_quantity') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Category</label>
                                    <select wire:model="category_id" class="block w-full bg-black/20 border-white/10 rounded-lg shadow-sm text-white focus:ring-brand-accent focus:border-brand-accent sm:text-sm">
                                        <option value="" class="bg-gray-900">None</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" class="bg-gray-900">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Image URL</label>
                                <input type="url" wire:model="image_url" class="block w-full bg-black/20 border-white/10 rounded-lg shadow-sm text-white focus:ring-brand-accent focus:border-brand-accent sm:text-sm" placeholder="https://...">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Tags</label>
                                <div class="flex flex-wrap gap-2 p-3 bg-black/20 border border-white/10 rounded-lg">
                                    @foreach($allTags as $tag)
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" wire:model="selectedTags" value="{{ $tag->id }}" class="rounded border-gray-600 text-brand-accent focus:ring-brand-accent bg-gray-800">
                                            <span class="ml-2 text-sm px-2 py-1 rounded-md" style="background-color: {{ $tag->color }}40; color: white; border: 1px solid {{ $tag->color }}60;">{{ $tag->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Variants Section -->
                            <div class="border-t border-white/10 pt-6 mt-6">
                                <h4 class="text-lg font-bold text-white mb-4">Product Variants</h4>
                                
                                <!-- Options Definition -->
                                <div class="mb-6 bg-white/5 border border-white/10 p-4 rounded-xl">
                                    <label class="block text-sm font-medium text-gray-400 mb-3">Variant Options (e.g. Size, Color)</label>
                                    @foreach($variantOptions as $index => $option)
                                        <div class="flex gap-3 mb-3">
                                            <input type="text" wire:model="variantOptions.{{ $index }}.name" placeholder="Name (e.g. Size)" class="w-1/3 bg-black/20 border-white/10 rounded-lg text-white text-sm">
                                            <input type="text" wire:model="variantOptions.{{ $index }}.values" placeholder="Values (comma separated)" class="w-full bg-black/20 border-white/10 rounded-lg text-white text-sm">
                                            <button wire:click="removeVariantOption({{ $index }})" class="text-red-400 hover:text-red-300 p-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                    <div class="flex gap-4 mt-4">
                                        <button wire:click="addVariantOption" class="text-sm text-brand-accent hover:text-blue-400 font-medium">+ Add Option</button>
                                        <button wire:click="generateVariants" class="text-sm text-brand-accent hover:text-blue-400 font-medium">Generate Variants</button>
                                    </div>
                                </div>

                                <!-- Variants List -->
                                @if(count($variants) > 0)
                                    <div class="overflow-x-auto rounded-xl border border-white/10">
                                        <table class="min-w-full divide-y divide-white/10">
                                            <thead class="bg-white/5">
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Options</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">SKU</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Price</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Stock</th>
                                                    <th class="px-4 py-3"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-white/10 bg-black/20">
                                                @foreach($variants as $index => $variant)
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-300">
                                                            @foreach($variant['options'] as $key => $val)
                                                                <span class="inline-block bg-white/10 rounded px-2 py-0.5 text-xs mr-1">{{ $key }}: {{ $val }}</span>
                                                            @endforeach
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            <input type="text" wire:model="variants.{{ $index }}.sku" class="w-full bg-black/20 border-white/10 rounded text-white text-xs">
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            <input type="number" step="0.01" wire:model="variants.{{ $index }}.price" class="w-24 bg-black/20 border-white/10 rounded text-white text-xs" placeholder="Default">
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            <input type="number" wire:model="variants.{{ $index }}.stock_quantity" class="w-24 bg-black/20 border-white/10 rounded text-white text-xs">
                                                        </td>
                                                        <td class="px-4 py-3 text-right">
                                                            <button wire:click="removeVariant({{ $index }})" class="text-red-400 hover:text-red-300">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                        </div>
                    </div>
                    <div class="bg-black/40 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-white/10">
                        <button wire:click="store" type="button" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-brand-accent text-base font-bold text-white hover:bg-blue-600 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Save Product
                        </button>
                        <button wire:click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-white/10 shadow-sm px-4 py-2 bg-white/5 text-base font-medium text-gray-300 hover:bg-white/10 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
