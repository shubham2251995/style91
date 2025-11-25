<div>
    <h2 class="text-2xl font-bold mb-4">Flash Sales Manager</h2>
    <button wire:click="create" class="bg-indigo-600 text-white px-4 py-2 rounded mb-4">Create Flash Sale</button>

    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">Product</th>
                <th class="px-4 py-2 border">Discount</th>
                <th class="px-4 py-2 border">Start Time</th>
                <th class="px-4 py-2 border">End Time</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td class="px-4 py-2 border">{{ $sale->product->name ?? 'Unknown' }}</td>
                    <td class="px-4 py-2 border">{{ $sale->discount_percentage }}%</td>
                    <td class="px-4 py-2 border">{{ $sale->start_time->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-2 border">{{ $sale->end_time->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-2 border">
                        <button wire:click="toggleStatus({{ $sale->id }})" class="px-2 py-1 rounded text-xs font-bold {{ $sale->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $sale->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td class="px-4 py-2 border">
                        <button wire:click="delete({{ $sale->id }})" class="text-red-600 hover:underline" onclick="return confirm('Delete this sale?')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-96">
                <h3 class="text-xl font-bold mb-4">Create Flash Sale</h3>
                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Product</label>
                        <select wire:model="productId" class="w-full border rounded p-2">
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        @error('productId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Discount (%)</label>
                        <input type="number" wire:model="discountPercentage" class="w-full border rounded p-2">
                        @error('discountPercentage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Start Time</label>
                        <input type="datetime-local" wire:model="startTime" class="w-full border rounded p-2">
                        @error('startTime') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">End Time</label>
                        <input type="datetime-local" wire:model="endTime" class="w-full border rounded p-2">
                        @error('endTime') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 border rounded">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
