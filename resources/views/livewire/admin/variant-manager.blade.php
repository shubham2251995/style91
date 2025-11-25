<div>
    <h2 class="text-2xl font-bold mb-4">Product Variants</h2>
    <button wire:click="create" class="bg-indigo-600 text-white px-4 py-2 rounded mb-4">Add Variant</button>

    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Product</th>
                <th class="px-4 py-2 border">SKU</th>
                <th class="px-4 py-2 border">Price</th>
                <th class="px-4 py-2 border">Stock</th>
                <th class="px-4 py-2 border">Active</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($variants as $variant)
                <tr>
                    <td class="px-4 py-2 border">{{ $variant->id }}</td>
                    <td class="px-4 py-2 border">{{ $variant->product->name ?? '—' }}</td>
                    <td class="px-4 py-2 border">{{ $variant->sku }}</td>
                    <td class="px-4 py-2 border">{{ $variant->price }}</td>
                    <td class="px-4 py-2 border">{{ $variant->stock_quantity }}</td>
                    <td class="px-4 py-2 border text-center">
                        @if($variant->is_active)
                            <span class="text-green-600">✔</span>
                        @else
                            <span class="text-red-600">✖</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border">
                        <button wire:click="edit({{ $variant->id }})" class="bg-blue-500 text-white px-2 py-1 rounded mr-2">Edit</button>
                        <button wire:click="delete({{ $variant->id }})" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Delete this variant?')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div x-data="{ open: @entangle('showModal') }" x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded shadow-lg p-6 w-1/2" @click.away="open = false">
            <h3 class="text-xl font-semibold mb-4" x-text="{{ $variantId ? 'Edit Variant' : 'Create Variant' }}"></h3>
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium">Product</label>
                        <select wire:model="productId" class="w-full border rounded p-2">
                            <option value="">Select product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium">SKU</label>
                        <input type="text" wire:model="sku" class="w-full border rounded p-2" />
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
                        <label class="block font-medium">Stock Quantity</label>
                        <input type="number" wire:model="stock_quantity" class="w-full border rounded p-2" />
                    </div>
                    <div>
                        <label class="block font-medium">Image URL</label>
                        <input type="url" wire:model="image_url" class="w-full border rounded p-2" />
                    </div>
                    <div class="col-span-2">
                        <label class="block font-medium">Options (JSON)</label>
                        <textarea wire:model="optionValues" rows="3" class="w-full border rounded p-2"></textarea>
                    </div>
                    <div class="col-span-2 flex items-center">
                        <label class="mr-2"><input type="checkbox" wire:model="is_active" /> Active</label>
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
