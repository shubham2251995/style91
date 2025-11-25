<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Product Manager</h2>
            <button wire:click="create" class="bg-brand-dark text-white px-4 py-2 rounded-lg hover:bg-brand-accent hover:text-brand-dark transition-colors font-bold">
                + Add Product
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Search products..." class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <select wire:model.live="filterCategory" class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select wire:model.live="filterStock" class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="">All Stock</option>
                        <option value="in">In Stock</option>
                        <option value="low">Low Stock (&lt;10)</option>
                        <option value="out">Out of Stock</option>
                    </select>
                </div>
                <div>
                    <button wire:click="$set('searchTerm', ''); $set('filterCategory', ''); $set('filterStock', '')" class="w-full bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm hover:bg-gray-300">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tags</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 rounded object-cover mr-3">
                                    @else
                                        <div class="w-12 h-12 rounded bg-gray-200 mr-3 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-500">/{{ $product->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->category?->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                ₹{{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock_quantity > 10 ? 'bg-green-100 text-green-800' : ($product->stock_quantity > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $product->stock_quantity }} units
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($product->tags as $tag)
                                        <span class="px-2 py-1 text-xs rounded-full text-white" style="background-color: {{ $tag->color }}">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $product->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                <button wire:click="duplicate({{ $product->id }})" class="text-blue-600 hover:text-blue-900 mr-3">Duplicate</button>
                                <button wire:click="delete({{ $product->id }})" class="text-red-600 hover:text-red-900" onclick="confirm('Delete this product?') || event.stopImmediatePropagation()">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <p class="text-lg font-medium">No products found</p>
                                    <p class="text-sm">Add your first product to get started</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

        <!-- Modal -->
        @if($isModalOpen)
        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            {{ $productId ? 'Edit Product' : 'Create Product' }}
                        </h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Product Name *</label>
                                    <input type="text" wire:model.live="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Slug *</label>
                                    <input type="text" wire:model="slug" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                    @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea wire:model="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm"></textarea>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Price (₹) *</label>
                                    <input type="number" step="0.01" wire:model="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                    @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Stock Quantity *</label>
                                    <input type="number" wire:model="stock_quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                    @error('stock_quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Category</label>
                                    <select wire:model="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                        <option value="">None</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Image URL</label>
                                <input type="url" wire:model="image_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm" placeholder="https://...">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($allTags as $tag)
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="selectedTags" value="{{ $tag->id }}" class="rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                                            <span class="ml-2 text-sm px-2 py-1 rounded" style="background-color: {{ $tag->color }}; color: white;">{{ $tag->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Variants Section -->
                            <div class="border-t pt-4 mt-4">
                                <h4 class="text-md font-bold text-gray-800 mb-2">Product Variants</h4>
                                
                                <!-- Options Definition -->
                                <div class="mb-4 bg-gray-50 p-3 rounded">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Variant Options (e.g. Size, Color)</label>
                                    @foreach($variantOptions as $index => $option)
                                        <div class="flex gap-2 mb-2">
                                            <input type="text" wire:model="variantOptions.{{ $index }}.name" placeholder="Name (e.g. Size)" class="w-1/3 border-gray-300 rounded-md shadow-sm sm:text-sm">
                                            <input type="text" wire:model="variantOptions.{{ $index }}.values" placeholder="Values (comma separated, e.g. S, M, L)" class="w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                            <button wire:click="removeVariantOption({{ $index }})" class="text-red-500 hover:text-red-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                    <div class="flex gap-2 mt-2">
                                        <button wire:click="addVariantOption" class="text-sm text-brand-dark hover:underline">+ Add Option</button>
                                        <button wire:click="generateVariants" class="text-sm text-brand-dark hover:underline ml-4">Generate Variants</button>
                                    </div>
                                </div>

                                <!-- Variants List -->
                                @if(count($variants) > 0)
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Options</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                                                    <th class="px-3 py-2"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($variants as $index => $variant)
                                                    <tr>
                                                        <td class="px-3 py-2 text-sm text-gray-900">
                                                            @foreach($variant['options'] as $key => $val)
                                                                <span class="inline-block bg-gray-100 rounded px-1 text-xs">{{ $key }}: {{ $val }}</span>
                                                            @endforeach
                                                        </td>
                                                        <td class="px-3 py-2">
                                                            <input type="text" wire:model="variants.{{ $index }}.sku" class="w-full border-gray-300 rounded-md shadow-sm text-xs">
                                                        </td>
                                                        <td class="px-3 py-2">
                                                            <input type="number" step="0.01" wire:model="variants.{{ $index }}.price" class="w-20 border-gray-300 rounded-md shadow-sm text-xs" placeholder="Default">
                                                        </td>
                                                        <td class="px-3 py-2">
                                                            <input type="number" wire:model="variants.{{ $index }}.stock_quantity" class="w-20 border-gray-300 rounded-md shadow-sm text-xs">
                                                        </td>
                                                        <td class="px-3 py-2 text-right">
                                                            <button wire:click="removeVariant({{ $index }})" class="text-red-500 hover:text-red-700">
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
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="store" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand-dark text-base font-medium text-white hover:bg-brand-accent hover:text-brand-dark sm:ml-3 sm:w-auto sm:text-sm">
                            Save Product
                        </button>
                        <button wire:click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
