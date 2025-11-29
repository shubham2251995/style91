<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Flash Sale Campaigns</h2>
            <button wire:click="create" class="bg-brand-dark text-white px-4 py-2 rounded-lg hover:bg-brand-accent hover:text-brand-dark transition-colors font-bold">
                + New Campaign
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campaign Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($sales as $sale)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $sale->name }}</div>
                                <div class="text-xs text-gray-500">{{ $sale->slug }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $sale->products_count }} items
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>Start: {{ $sale->start_time->format('M d, H:i') }}</div>
                                <div>End: {{ $sale->end_time->format('M d, H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $sale->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $sale->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="manageProducts({{ $sale->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3 font-bold">Manage Products</button>
                                <button wire:click="delete({{ $sale->id }})" class="text-red-600 hover:text-red-900" onclick="confirm('Delete this campaign?') || event.stopImmediatePropagation()">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">No active campaigns</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Campaign Modal -->
        @if($showModal)
        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $saleId ? 'Edit Campaign' : 'New Campaign' }}</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Campaign Name</label>
                                <input type="text" wire:model="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Start Time</label>
                                    <input type="datetime-local" wire:model="startTime" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">End Time</label>
                                    <input type="datetime-local" wire:model="endTime" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="save" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand-dark text-white hover:bg-brand-accent hover:text-brand-dark sm:ml-3 sm:w-auto sm:text-sm">Save</button>
                        <button wire:click="$set('showModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Product Management Modal -->
        @if($showProductModal && $activeSale)
        <div class="fixed z-20 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-900">Manage Products for "{{ $activeSale->name }}"</h3>
                            <button wire:click="$set('showProductModal', false)" class="text-gray-400 hover:text-gray-500">
                                <span class="text-2xl">&times;</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Add Product -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-bold mb-3 text-sm uppercase">Add Product</h4>
                                <div class="space-y-3">
                                    <select wire:change="addProduct($event.target.value)" class="block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                        <option value="">Select a product to add...</option>
                                        @foreach($products as $product)
                                            @if(!$activeSale->products->contains($product->id))
                                                <option value="{{ $product->id }}">{{ $product->name }} (₹{{ $product->price }})</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="text-xs font-bold text-gray-500">Discount %</label>
                                            <input type="number" wire:model.live="discountPercentage" class="block w-full border-gray-300 rounded-md shadow-sm text-sm" placeholder="e.g. 20">
                                        </div>
                                        <div>
                                            <label class="text-xs font-bold text-gray-500">Fixed Price</label>
                                            <input type="number" wire:model.live="fixedPrice" class="block w-full border-gray-300 rounded-md shadow-sm text-sm" placeholder="e.g. 999">
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500">Set discount OR fixed price before selecting product.</p>
                                </div>
                            </div>

                            <!-- Product List -->
                            <div class="border rounded-lg overflow-hidden max-h-[400px] overflow-y-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Deal</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($activeSale->products as $product)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $product->name }}</td>
                                                <td class="px-4 py-2 text-sm font-bold text-brand-accent">
                                                    @if($product->pivot->fixed_price)
                                                        ₹{{ number_format($product->pivot->fixed_price) }}
                                                    @else
                                                        {{ $product->pivot->discount_percentage }}% OFF
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2 text-right">
                                                    <button wire:click="removeProduct({{ $product->id }})" class="text-red-500 hover:text-red-700 text-xs font-bold">Remove</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
