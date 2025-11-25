<div>
    <!-- Address List -->
    @if(!$showForm)
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-brand-dark">Saved Addresses</h2>
            <button 
                wire:click="openForm"
                class="bg-brand-accent text-brand-dark px-4 py-2 rounded-lg font-bold text-sm hover:bg-yellow-400 transition"
            >
                + ADD NEW
            </button>
        </div>

                    @if($address->label)
                        <p class="text-xs text-gray-500 uppercase font-bold mb-1">{{ $address->label }}</p>
                    @endif
                    <p class="font-bold text-brand-dark">{{ $address->full_name }}</p>
                    <p class="text-sm text-gray-600 mt-2">{{ $address->address_line1 }}</p>
                    @if($address->address_line2)
                        <p class="text-sm text-gray-600">{{ $address->address_line2 }}</p>
                    @endif
                    <p class="text-sm text-gray-600">{{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}</p>
                    <p class="text-sm text-gray-600">{{ $address->country }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $address->phone }}</p>

                    <div class="flex gap-2 mt-4">
                        @if(!$address->is_default)
                            <button 
                                wire:click="setDefault({{ $address->id }})"
                                class="text-xs bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-gray-300"
                            >
                                SET DEFAULT
                            </button>
                        @endif
                        <button 
                            wire:click="openForm({{ $address->id }})"
                            class="text-xs bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-gray-300"
                        >
                            EDIT
                        </button>
                        <button 
                            wire:click="delete({{ $address->id }})"
                            wire:confirm="Are you sure you want to delete this address?"
                            class="text-xs bg-red-100 text-red-600 px-3 py-1 rounded hover:bg-red-200"
                        >
                            DELETE
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <p class="text-gray-500 mb-4">No saved addresses</p>
            </div>
        @endif
    @else
        <!-- Address Form -->
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg text-brand-dark">{{ $editingId ? 'Edit' : 'Add New' }} Address</h3>
                <button wire:click="closeForm" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Label (Optional)</label>
                        <input wire:model="label" type="text" placeholder="e.g. Home, Office" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Full Name *</label>
                        <input wire:model="full_name" type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        @error('full_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Phone *</label>
                    <input wire:model="phone" type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Address Line 1 *</label>
                    <input wire:model="address_line1" type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    @error('address_line1') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Address Line 2</label>
                    <input wire:model="address_line2" type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">City *</label>
                        <input wire:model="city" type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">State</label>
                        <input wire:model="state" type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">ZIP Code *</label>
                        <input wire:model="zip_code" type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        @error('zip_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Country *</label>
                    <select wire:model="country" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <option value="India">India</option>
                        <option value="US">United States</option>
                        <option value="UK">United Kingdom</option>
                    </select>
                </div>

                <div>
                    <label class="flex items-center gap-2">
                        <input wire:model="is_default" type="checkbox" class="rounded border-gray-300">
                        <span class="text-sm font-bold text-gray-700">Set as default address</span>
                    </label>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-brand-accent text-brand-dark py-3 rounded-lg font-bold hover:bg-yellow-400 transition">
                        {{ $editingId ? 'UPDATE' : 'SAVE' }} ADDRESS
                    </button>
                    <button type="button" wire:click="closeForm" class="px-6 bg-gray-200 text-gray-700 py-3 rounded-lg font-bold hover:bg-gray-300 transition">
                        CANCEL
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
