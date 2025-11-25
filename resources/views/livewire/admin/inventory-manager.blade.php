<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Inventory Manager</h2>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="text-sm text-gray-500">Total Products</div>
                <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="text-sm text-gray-500">Low Stock</div>
                <div class="text-2xl font-bold text-yellow-600">{{ $stats['low_stock'] }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="text-sm text-gray-500">Out of Stock</div>
                <div class="text-2xl font-bold text-red-600">{{ $stats['out_of_stock'] }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="text-sm text-gray-500">Total Value</div>
                <div class="text-2xl font-bold text-green-600">₹{{ number_format($stats['total_value'], 2) }}</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                        <option value="all">All Stock Levels</option>
                        <option value="in">In Stock</option>
                        <option value="low">Low Stock</option>
                        <option value="out">Out of Stock</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Inventory Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-10 h-10 rounded object-cover mr-3">
                                    @endif
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->category?->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                ₹{{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold">
                                {{ $product->stock_quantity }} units
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ₹{{ number_format($product->price * $product->stock_quantity, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->stock_quantity > $lowStockThreshold)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        In Stock
                                    </span>
                                @elseif($product->stock_quantity > 0)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Low Stock
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Out of Stock
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg font-medium">No products found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($products->hasPages())
                <div class="px-6 py-4 border-t">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
