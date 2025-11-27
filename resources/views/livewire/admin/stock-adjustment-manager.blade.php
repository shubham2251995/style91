<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Stock Adjustments</h2>
        <button wire:click="openModal" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium">
            + New Adjustment
        </button>
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

    <!-- Adjustments Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Variant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Change</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Old → New</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($adjustments as $adjustment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $adjustment->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $adjustment->product->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $adjustment->variant ? json_encode($adjustment->variant->options) : '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $adjustment->quantity_change > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $adjustment->formatted_change }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $adjustment->old_quantity }} → {{ $adjustment->new_quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $adjustment->reason === 'damaged' ? 'bg-red-100 text-red-800' : ($adjustment->reason === 'returned' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($adjustment->reason) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $adjustment->user->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $adjustment->notes ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            No stock adjustments yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4 bg-gray-50">
            {{ $adjustments->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <h3 class="text-xl font-bold mb-4">Adjust Stock</h3>
                
                <form wire:submit.prevent="adjustStock">
                    <!-- Product Search -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Product</label>
                        <input type="text" wire:model.live="searchTerm" placeholder="Search products..." class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        
                        @if($searchTerm && $products->count() > 0)
                            <div class="mt-2 border border-gray-200 rounded-lg max-h-48 overflow-y-auto">
                                @foreach($products as $product)
                                    <div wire:click="selectProduct({{ $product->id }})" class="p-3 hover:bg-gray-50 cursor-pointer {{ $productId == $product->id ? 'bg-indigo-50' : '' }}">
                                        <div class="font-medium">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-500">Stock: {{ $product->stock_quantity }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if($selectedProduct)
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                            <div class="font-medium">Selected: {{ $selectedProduct->name }}</div>
                            <div class="text-sm text-gray-600">Current Stock: {{ $selectedProduct->stock_quantity }}</div>

                            <!-- Variant Selection -->
                            @if($selectedProduct->variants->count() > 0)
                                <div class="mt-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Variant (Optional)</label>
                                    <div class="space-y-2">
                                        @foreach($selectedProduct->variants as $variant)
                                            <div wire:click="selectVariant({{ $variant->id }})" class="p-2 border rounded cursor-pointer {{ $variantId == $variant->id ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                                                <div class="text-sm">{{ json_encode($variant->options) }}</div>
                                                <div class="text-xs text-gray-500">Stock: {{ $variant->stock_quantity ?? 0 }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Quantity Change -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity Change</label>
                            <input type="number" wire:model="quantityChange" class="w-full border border-gray-300 rounded-lg px-4 py-2" placeholder="e.g., +10 or -5">
                            @error('quantityChange') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Use positive numbers to add stock, negative to reduce</p>
                        </div>

                        <!-- Reason -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Reason</label>
                            <select wire:model="reason" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                <option value="manual">Manual Adjustment</option>
                                <option value="damaged">Damaged Goods</option>
                                <option value="returned">Customer Return</option>
                                <option value="lost">Lost/Stolen</option>
                                <option value="found">Found/Recovered</option>
                                <option value="correction">Inventory Correction</option>
                                <option value="supplier">Supplier Delivery</option>
                            </select>
                            @error('reason') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                            <textarea wire:model="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2" placeholder="Add any additional notes..."></textarea>
                            @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Please search and select a product to adjust stock</p>
                    @endif

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700" {{ !$selectedProduct ? 'disabled' : '' }}>
                            Adjust Stock
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
