<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Homepage Sections</h2>
        <button wire:click="create" class="bg-brand-accent text-black font-bold px-4 py-2 rounded hover:opacity-90">
            Add New Section
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- List -->
        <div class="lg:col-span-2 space-y-4" wire:sortable="updateOrder">
            @foreach($sections as $section)
                <div wire:sortable.item="{{ $section->id }}" wire:key="section-{{ $section->id }}" class="bg-gray-800 p-4 rounded-xl border border-gray-700 flex items-center gap-4">
                    <div wire:sortable.handle class="cursor-move text-gray-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </div>
                    
                    <div class="w-16 h-16 bg-gray-700 rounded overflow-hidden flex-shrink-0">
                        @if($section->image_url)
                            <img src="{{ $section->image_url }}" class="w-full h-full object-cover">
                        @endif
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <h4 class="font-bold text-lg">{{ $section->title }}</h4>
                            <span class="text-xs bg-gray-700 px-2 py-0.5 rounded text-gray-300 uppercase">{{ $section->type }}</span>
                        </div>
                        <p class="text-sm text-gray-400 truncate">{{ $section->subtitle }}</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button wire:click="toggleActive({{ $section->id }})" class="{{ $section->is_active ? 'text-green-400' : 'text-gray-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                            </svg>
                        </button>
                        <button wire:click="edit({{ $section->id }})" class="text-blue-400 hover:text-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </button>
                        <button wire:click="delete({{ $section->id }})" class="text-red-400 hover:text-red-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Form -->
        <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 h-fit sticky top-6">
            <h3 class="text-xl font-bold mb-4 text-brand-accent">{{ $editingSectionId ? 'Edit Section' : 'Create Section' }}</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Type</label>
                    <select wire:model="type" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white">
                        <option value="hero">Hero Banner</option>
                        <option value="featured_collection">Featured Collection</option>
                        <option value="grid">Grid Layout</option>
                        <option value="newsletter">Newsletter</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Title</label>
                    <input type="text" wire:model="title" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Subtitle</label>
                    <input type="text" wire:model="subtitle" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Image</label>
                    @if($newImage)
                        <img src="{{ $newImage->temporaryUrl() }}" class="w-full h-32 object-cover rounded mb-2">
                    @elseif($image_url)
                        <img src="{{ $image_url }}" class="w-full h-32 object-cover rounded mb-2">
                    @endif
                    <input type="file" wire:model="newImage" class="text-sm text-gray-400">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Link URL</label>
                        <input type="text" wire:model="link_url" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Link Text</label>
                        <input type="text" wire:model="link_text" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white">
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Order</label>
                    <input type="number" wire:model="order" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white">
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" wire:model="is_active" id="is_active" class="rounded bg-gray-900 border-gray-600 text-brand-accent">
                    <label for="is_active" class="text-sm text-gray-300">Active</label>
                </div>

                <button wire:click="save" class="w-full bg-brand-accent text-black font-bold py-2 rounded hover:opacity-90 mt-4">
                    {{ $editingSectionId ? 'Update Section' : 'Create Section' }}
                </button>
                
                @if($editingSectionId)
                    <button wire:click="resetForm" class="w-full bg-gray-700 text-white font-bold py-2 rounded hover:bg-gray-600 mt-2">
                        Cancel
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
