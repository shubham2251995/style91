<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Tag Manager</h2>
            <button wire:click="create" class="bg-brand-dark text-white px-4 py-2 rounded-lg hover:bg-brand-accent hover:text-brand-dark transition-colors font-bold">
                + Add Tag
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($tags as $tag)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full mr-3" style="background-color: {{ $tag->color }}"></div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $tag->name }}</h3>
                                <p class="text-xs text-gray-500">/{{ $tag->slug }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white" style="background-color: {{ $tag->color }}">
                            {{ $tag->products_count }} {{ Str::plural('product', $tag->products_count) }}
                        </span>
                    </div>

                    <div class="flex gap-2">
                        <button wire:click="edit({{ $tag->id }})" class="flex-1 bg-gray-100 text-gray-700 px-3 py-2 rounded-lg text-sm hover:bg-gray-200">
                            Edit
                        </button>
                        <button wire:click="delete({{ $tag->id }})" class="bg-red-100 text-red-700 px-3 py-2 rounded-lg text-sm hover:bg-red-200" onclick="confirm('Delete this tag?') || event.stopImmediatePropagation()">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3">
                <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <p class="text-lg font-medium text-gray-900">No tags yet</p>
                    <p class="text-sm text-gray-500 mt-2">Create tags to organize your products</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Modal -->
        @if($isModalOpen)
        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            {{ $tagId ? 'Edit Tag' : 'Create Tag' }}
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name *</label>
                                <input type="text" wire:model.live="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Slug *</label>
                                <input type="text" wire:model="slug" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                                <div class="flex items-center gap-4">
                                    <input type="color" wire:model.live="color" class="h-12 w-24 border-gray-300 rounded cursor-pointer">
                                    <div class="flex-1">
                                        <input type="text" wire:model.live="color" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm font-mono">
                                    </div>
                                    <div class="px-4 py-2 rounded-lg text-white font-medium" style="background-color: {{ $color }}">
                                        Preview
                                    </div>
                                </div>
                                @error('color') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="store" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand-dark text-base font-medium text-white hover:bg-brand-accent hover:text-brand-dark sm:ml-3 sm:w-auto sm:text-sm">
                            Save
                        </button>
                        <button wire:click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
