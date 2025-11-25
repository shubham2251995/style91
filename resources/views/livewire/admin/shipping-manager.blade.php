<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Shipping Management</h2>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Tabs -->
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button wire:click="$set('activeTab', 'methods')" class="px-6 py-3 border-b-2 font-medium text-sm {{ $activeTab === 'methods' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        Shipping Methods
                    </button>
                    <button wire:click="$set('activeTab', 'zones')" class="px-6 py-3 border-b-2 font-medium text-sm {{ $activeTab === 'zones' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        Shipping Zones
                    </button>
                </nav>
            </div>
        </div>

        <!-- Shipping Methods Tab -->
        @if($activeTab === 'methods')
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Shipping Methods</h3>
                    <button wire:click="openMethodModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        + Add Method
                    </button>
                </div>

                <div class="space-y-4">
                    @forelse($methods as $method)
                        <div class="border rounded-lg p-4 flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h4 class="text-lg font-bold">{{ $method->name }}</h4>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $method->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $method->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                        {{ ucfirst(str_replace('_', ' ', $method->type)) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">{{ $method->description }}</p>
                                <div class="flex gap-4 text-sm text-gray-700">
                                    <span>💰 Cost: ₹{{ number_format($method->cost, 2) }}</span>
                                    @if($method->min_order_amount)
                                        <span>📦 Min Order: ₹{{ number_format($method->min_order_amount, 2) }}</span>
                                    @endif
                                    <span>⏱️ Delivery: {{ $method->getEstimatedDelivery() }}</span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="toggleMethodStatus({{ $method->id }})" class="px-3 py-1 text-sm {{ $method->is_active ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }} rounded hover:opacity-80">
                                    {{ $method->is_active ? 'Disable' : 'Enable' }}
                                </button>
                                <button wire:click="openMethodModal({{ $method->id }})" class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded hover:bg-blue-200">
                                    Edit
                                </button>
                                <button wire:click="deleteMethod({{ $method->id }})" onclick="confirm('Delete this shipping method?') || event.stopImmediatePropagation()" class="px-3 py-1 text-sm bg-red-100 text-red-800 rounded hover:bg-red-200">
                                    Delete
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8">No shipping methods found. Add one to get started!</p>
                    @endforelse
                </div>
            </div>
        @endif

        <!-- Shipping Zones Tab -->
        @if($activeTab === 'zones')
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Shipping Zones</h3>
                    <button wire:click="openZoneModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        + Add Zone
                    </button>
                </div>

                <div class="space-y-4">
                    @forelse($zones as $zone)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-lg font-bold">{{ $zone->name }}</h4>
                                <div class="flex gap-2">
                                    <button wire:click="openZoneModal({{ $zone->id }})" class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded hover:bg-blue-200">
                                        Edit
                                    </button>
                                    <button wire:click="deleteZone({{ $zone->id }})" onclick="confirm('Delete this zone?') || event.stopImmediatePropagation()" class="px-3 py-1 text-sm bg-red-100 text-red-800 rounded hover:bg-red-200">
                                        Delete
                                    </button>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600">
                                @if($zone->countries)
                                    <p>Countries: {{ implode(', ', $zone->countries) }}</p>
                                @endif
                                @if($zone->states)
                                    <p>States: {{ implode(', ', $zone->states) }}</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8">No shipping zones found.</p>
                    @endforelse
                </div>
            </div>
        @endif

        <!-- Method Modal -->
        @if($isMethodModalOpen)
        <div class="fixed z-50 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <h3 class="text-lg font-bold mb-4">{{ $methodId ? 'Edit' : 'Add' }} Shipping Method</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                                <input type="text" wire:model="name" class="w-full border-gray-300 rounded-lg">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea wire:model="description" rows="2" class="w-full border-gray-300 rounded-lg"></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                                    <select wire:model="type" class="w-full border-gray-300 rounded-lg">
                                        <option value="flat_rate">Flat Rate</option>
                                        <option value="free_shipping">Free Shipping</option>
                                        <option value="local_pickup">Local Pickup</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cost (₹) *</label>
                                    <input type="number" step="0.01" wire:model="cost" class="w-full border-gray-300 rounded-lg">
                                    @error('cost') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Min Order Amount for Free Shipping (₹)</label>
                                <input type="number" step="0.01" wire:model="minOrderAmount" class="w-full border-gray-300 rounded-lg">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Est. Days (Min) *</label>
                                    <input type="number" wire:model="estimatedDaysMin" class="w-full border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Est. Days (Max) *</label>
                                    <input type="number" wire:model="estimatedDaysMax" class="w-full border-gray-300 rounded-lg">
                                </div>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" wire:model="isActive" id="isActive" class="rounded">
                                <label for="isActive" class="ml-2 text-sm text-gray-700">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button wire:click="saveMethod" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Save
                        </button>
                        <button wire:click="closeMethodModal" class="w-full sm:w-auto px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 mt-2 sm:mt-0">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Zone Modal -->
        @if($isZoneModalOpen)
        <div class="fixed z-50 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <h3 class="text-lg font-bold mb-4">{{ $zoneId ? 'Edit' : 'Add' }} Shipping Zone</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Zone Name *</label>
                                <input type="text" wire:model="zoneName" class="w-full border-gray-300 rounded-lg">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Countries (comma-separated codes)</label>
                                <input type="text" wire:model="countries" class="w-full border-gray-300 rounded-lg" placeholder="IN, US, UK">
                                <p class="text-xs text-gray-500 mt-1">Enter ISO country codes separated by commas</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">States (comma-separated)</label>
                                <input type="text" wire:model="states" class="w-full border-gray-300 rounded-lg" placeholder="MH, DL, KA">
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" wire:model="isZoneActive" id="isZoneActive" class="rounded">
                                <label for="isZoneActive" class="ml-2 text-sm text-gray-700">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button wire:click="saveZone" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Save
                        </button>
                        <button wire:click="closeZoneModal" class="w-full sm:w-auto px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 mt-2 sm:mt-0">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
