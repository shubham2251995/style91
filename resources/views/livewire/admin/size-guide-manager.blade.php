<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Size Guide Manager</h2>
            <button wire:click="createNew" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Add Size Guide
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Size Guides List -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($sizeGuides as $guide)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $guide->name }}</div>
                                @if($guide->description)
                                    <div class="text-sm text-gray-500">{{ Str::limit($guide->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $guide->category->name ?? 'All Categories' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ strtoupper($guide->measurement_unit) }}
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="toggleStatus({{ $guide->id }})" class="px-3 py-1 text-xs rounded-full {{ $guide->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $guide->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button wire:click="editSizeGuide({{ $guide->id }})" class="text-blue-600 hover:text-blue-800">
                                    Edit
                                </button>
                                <button wire:click="deleteSizeGuide({{ $guide->id }})" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-800">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                No size guides found. Click "Add Size Guide" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        @if($isModalOpen)
        <div class="fixed z-50 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <h3 class="text-lg font-bold mb-4">{{ $sizeGuideId ? 'Edit' : 'Create' }} Size Guide</h3>
                        
                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                                <input type="text" wire:model="name" class="w-full border-gray-300 rounded-lg" placeholder="e.g., Men's T-Shirts">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select wire:model="categoryId" class="w-full border-gray-300 rounded-lg">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea wire:model="description" rows="2" class="w-full border-gray-300 rounded-lg"></textarea>
                            </div>

                            <!-- Measurement Unit -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Measurement Unit</label>
                                <select wire:model="measurementUnit" class="w-full border-gray-300 rounded-lg">
                                    <option value="cm">Centimeters (cm)</option>
                                    <option value="inches">Inches</option>
                                </select>
                            </div>

                            <!-- Size Chart -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-bold text-sm mb-3">Size Chart</h4>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b">
                                                <th class="px-2 py-2 text-left">Measurement</th>
                                                @foreach($sizes as $size)
                                                    <th class="px-2 py-2 text-center">{{ $size }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(['chest', 'waist', 'hips', 'length'] as $measurement)
                                                <tr class="border-b">
                                                    <td class="px-2 py-2 font-medium capitalize">{{ $measurement }}</td>
                                                    @foreach($sizes as $index => $size)
                                                        <td class="px-2 py-2">
                                                            <input type="number" step="0.1" wire:model="measurements.{{ $measurement }}.{{ $index }}" class="w-20 border-gray-300 rounded text-center" placeholder="--">
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="flex items-center">
                                <input type="checkbox" wire:model="isActive" class="rounded">
                                <span class="ml-2 text-sm">Active</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button wire:click="saveSizeGuide" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Save Size Guide
                        </button>
                        <button wire:click="closeModal" class="w-full sm:w-auto px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 mt-2 sm:mt-0">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
