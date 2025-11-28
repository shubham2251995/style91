<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Menu Manager</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Sidebar: Menu List -->
        <div class="bg-gray-800 rounded-xl p-4 border border-gray-700">
            <h3 class="text-xl font-bold mb-4 text-brand-accent">Menus</h3>
            
            <div class="space-y-2 mb-6">
                @foreach($menus as $menu)
                    <div class="flex justify-between items-center p-2 rounded {{ $selectedMenu && $selectedMenu->id === $menu->id ? 'bg-brand-accent text-black' : 'bg-gray-700 hover:bg-gray-600' }} cursor-pointer"
                         wire:click="selectMenu({{ $menu->id }})">
                        <span>{{ $menu->name }}</span>
                        <span class="text-xs opacity-70">{{ $menu->location }}</span>
                        <button wire:click.stop="deleteMenu({{ $menu->id }})" class="text-red-500 hover:text-red-700 px-2">×</button>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-gray-700 pt-4">
                <h4 class="font-bold mb-2 text-sm">Create New Menu</h4>
                <div class="space-y-2">
                    <input type="text" wire:model="menuName" placeholder="Menu Name" class="w-full bg-gray-900 border border-gray-600 rounded px-2 py-1 text-sm">
                    <input type="text" wire:model="menuLocation" placeholder="Location (e.g. header)" class="w-full bg-gray-900 border border-gray-600 rounded px-2 py-1 text-sm">
                    <button wire:click="createMenu" class="w-full bg-brand-accent text-black font-bold py-1 rounded text-sm hover:opacity-90">Create</button>
                </div>
            </div>
        </div>

        <!-- Main Content: Menu Items -->
        <div class="md:col-span-2 bg-gray-800 rounded-xl p-4 border border-gray-700">
            @if($selectedMenu)
                <div class="flex justify-between items-center mb-4 border-b border-gray-700 pb-2">
                    <h3 class="text-xl font-bold">{{ $selectedMenu->name }} Items</h3>
                    <span class="text-sm text-gray-400">Location: {{ $selectedMenu->location }}</span>
                </div>

                <!-- Item Form -->
                <div class="bg-gray-900 p-4 rounded-lg mb-6 border border-gray-700">
                    <h4 class="font-bold mb-3 text-brand-accent">{{ $editingItemId ? 'Edit Item' : 'Add New Item' }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" wire:model="itemTitle" placeholder="Title" class="bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white">
                        <input type="text" wire:model="itemUrl" placeholder="URL (e.g. /shop)" class="bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white">
                        <input type="text" wire:model="itemRoute" placeholder="Route Name (optional)" class="bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white">
                        <select wire:model="itemParentId" class="bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white">
                            <option value="">No Parent</option>
                            @foreach($selectedMenu->items as $item)
                                @if($item->id !== $editingItemId)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endif
                            @endforeach
                        </select>
                        <input type="number" wire:model="itemOrder" placeholder="Order" class="bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white">
                        <select wire:model="itemTarget" class="bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white">
                            <option value="_self">Same Tab</option>
                            <option value="_blank">New Tab</option>
                        </select>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <button wire:click="saveItem" class="bg-green-500 text-black font-bold px-4 py-2 rounded hover:bg-green-400">
                            {{ $editingItemId ? 'Update Item' : 'Add Item' }}
                        </button>
                        @if($editingItemId)
                            <button wire:click="resetItemForm" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</button>
                        @endif
                    </div>
                </div>

                <!-- Items List -->
                <div class="space-y-2">
                    @foreach($menuItems as $item)
                        <div class="bg-gray-700 p-3 rounded flex justify-between items-center border border-gray-600">
                            <div>
                                <span class="font-bold">{{ $item->title }}</span>
                                <span class="text-xs text-gray-400 ml-2">{{ $item->url ?? $item->route }}</span>
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="editItem({{ $item->id }})" class="text-blue-400 hover:text-blue-300">Edit</button>
                                <button wire:click="deleteItem({{ $item->id }})" class="text-red-400 hover:text-red-300">Delete</button>
                            </div>
                        </div>
                        <!-- Children -->
                        @foreach($item->children as $child)
                            <div class="bg-gray-700 p-3 rounded flex justify-between items-center border border-gray-600 ml-8 border-l-4 border-l-brand-accent">
                                <div>
                                    <span class="font-bold">{{ $child->title }}</span>
                                    <span class="text-xs text-gray-400 ml-2">{{ $child->url ?? $child->route }}</span>
                                </div>
                                <div class="flex gap-2">
                                    <button wire:click="editItem({{ $child->id }})" class="text-blue-400 hover:text-blue-300">Edit</button>
                                    <button wire:click="deleteItem({{ $child->id }})" class="text-red-400 hover:text-red-300">Delete</button>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-500 py-10">
                    Select or create a menu to manage items.
                </div>
            @endif
        </div>
    </div>
</div>
