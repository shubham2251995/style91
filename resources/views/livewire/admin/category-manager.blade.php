<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Category Manager</h2>
            <button wire:click="create" class="bg-brand-dark text-white px-4 py-2 rounded-lg hover:bg-brand-accent hover:text-brand-dark transition-colors font-bold">
                + Add Category
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <!-- Parent Category -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($category->image_url)
                                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-10 h-10 rounded object-cover mr-3">
                                    @endif
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $category->name }}</div>
                                        @if($category->description)
                                            <div class="text-xs text-gray-500 line-clamp-1">{{ $category->description }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">/{{ $category->slug }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->products->count() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->display_order }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click="toggleActive({{ $category->id }})" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $category->id }})" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
                                <button wire:click="delete({{ $category->id }})" class="text-red-600 hover:text-red-900" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                            </td>
                        </tr>
                        
                        <!-- Child Categories -->
                        @foreach($category->children as $child)
                        <tr class="hover:bg-gray-50 bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center pl-8">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    @if($child->image_url)
                                        <img src="{{ $child->image_url }}" alt="{{ $child->name }}" class="w-8 h-8 rounded object-cover mr-2">
                                    @endif
                                    <div class="text-sm font-medium text-gray-700">{{ $child->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">/{{ $child->slug }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $child->products->count() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $child->display_order }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click="toggleActive({{ $child->id }})" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $child->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $child->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $child->id }})" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
                                <button wire:click="delete({{ $child->id }})" class="text-red-600 hover:text-red-900" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">No categories yet</p>
                                    <p class="text-sm">Get started by creating your first category</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        @if($isModalOpen)
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                            {{ $categoryId ? 'Edit Category' : 'Create Category' }}
                        </h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" wire:model.live="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Slug</label>
                                    <input type="text" wire:model="slug" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                    @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea wire:model="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm"></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Parent Category</label>
                                    <select wire:model="parent_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                        <option value="">None (Root Category)</option>
                                        @foreach($allCategories as $cat)
                                            @if(!$categoryId || $cat->id != $categoryId)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Display Order</label>
                                    <input type="number" wire:model="display_order" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Image URL</label>
                                <input type="url" wire:model="image_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm" placeholder="https://...">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Meta Title</label>
                                    <input type="text" wire:model="meta_title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Meta Keywords</label>
                                    <input type="text" wire:model="meta_keywords" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm" placeholder="keyword1, keyword2">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Meta Description</label>
                                <textarea wire:model="meta_description" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm"></textarea>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" wire:model="is_active" class="h-4 w-4 text-brand-dark focus:ring-brand-dark border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="store" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand-dark text-base font-medium text-white hover:bg-brand-accent hover:text-brand-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-dark sm:ml-3 sm:w-auto sm:text-sm">
                            Save
                        </button>
                        <button wire:click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
