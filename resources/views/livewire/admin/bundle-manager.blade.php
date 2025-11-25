<div>
    <h2 class="text-2xl font-bold mb-4">Product Bundles</h2>
    <button wire:click="create" class="bg-indigo-600 text-white px-4 py-2 rounded mb-4">Create Bundle</button>

    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Name</th>
                <th class="px-4 py-2 border">Price</th>
                <th class="px-4 py-2 border">Discount</th>
                <th class="px-4 py-2 border">Stock</th>
                <th class="px-4 py-2 border">Active</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bundles as $bundle)
                <tr>
                    <td class="px-4 py-2 border">{{ $bundle->id }}</td>
                    <td class="px-4 py-2 border">{{ $bundle->name }}</td>
                    <td class="px-4 py-2 border">{{ $bundle->price }}</td>
                    <td class="px-4 py-2 border">{{ $bundle->discount_percentage }}%</td>
                    <td class="px-4 py-2 border">{{ $bundle->stock_quantity }}</td>
                    <td class="px-4 py-2 border text-center">
                        @if($bundle->is_active)
                            <span class="text-green-600">✔</span>
                        @else
                            <span class="text-red-600">✖</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border">
                        <button wire:click="edit({{ $bundle->id }})" class="bg-blue-500 text-white px-2 py-1 rounded mr-2">Edit</button>
                        <button wire:click="delete({{ $bundle->id }})" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Delete this bundle?')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div x-data="{ open: @entangle('showModal') }" x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
        <div class="bg-white rounded shadow-lg p-6 w-3/4 max-h-[90vh] overflow-y-auto" @click.away="open = false">
            <h3 class="text-xl font-semibold mb-4" x-text="{{ $bundleId ? 'Edit Bundle' : 'Create Bundle' }}"></h3>
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium">Name</label>
                        <input type="text" wire:model="name" class="w-full border rounded p-2" />
                    </div>
                    <div>
                        <label class="block font-medium">Slug</label>
                        <input type="text" wire:model="slug" class="w-full border rounded p-2" />
                    </div>
                    <div class="col-span-2">
                        <label class="block font-medium">Description</label>
                        <textarea wire:model="description" class="w-full border rounded p-2"></textarea>
                    </div>
                    <div>
                        <label class="block font-medium">Price</label>
                        <input type="number" step="0.01" wire:model="price" class="w-full border rounded p-2" />
                    </div>
                    <div>
                        <label class="block font-medium">Compare Price</label>
                        <input type="number" step="0.01" wire:model="compare_price" class="w-full border rounded p-2" />
                    </div>
                    <div>
                        <label class="block font-medium">Discount (%)</label>
                        <input type="number" wire:model="discount_percentage" class="w-full border rounded p-2" />
                    </div>
                    <div>
                        <label class="block font-medium">Stock Quantity</label>
                        <input type="number" wire:model="stock_quantity" class="w-full border rounded p-2" />
                    </div>
                    <div class="col-span-2">
                        <label class="block font-medium">Image URL</label>
                        <input type="url" wire:model="image_url" class="w-full border rounded p-2" />
                    </div>
                    <div class="col-span-2 flex items-center">
                        <label class="mr-2"><input type="checkbox" wire:model="is_active" /> Active</label>
                    </div>

                    <div class="col-span-2 border-t pt-4 mt-4">
                        <h4 class="font-bold mb-2">Bundle Products</h4>
                        <!-- Simple UI to add products to bundle -->
                        <!-- In a real app, this would be a dynamic list with add/remove functionality -->
                        <!-- For now, we assume we can manage this via a JSON or simple multi-select if needed, 
                             but let's try to make a simple repeater -->
                        
                        <div class="space-y-2">
                            @foreach($selectedProducts as $index => $item)
                                <div class="flex gap-2 items-center">
                                    <select wire:model="selectedProducts.{{ $index }}.product_id" class="border rounded p-2 flex-1">
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" wire:model="selectedProducts.{{ $index }}.quantity" class="border rounded p-2 w-24" placeholder="Qty" />
                                    <button type="button" wire:click="$pull('selectedProducts', {{ $index }})" class="text-red-500">Remove</button>
                                </div>
                            @endforeach
                            <button type="button" wire:click="$push('selectedProducts', ['product_id' => '', 'quantity' => 1])" class="text-blue-600">+ Add Product</button>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="button" @click="open = false" class="mr-2 px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
