<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Homepage Section Manager</h1>
        <button wire:click="openModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Add Section
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($sections as $section)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $section['order'] }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                {{ $sectionTypes[$section['type']] ?? $section['type'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $section['title'] ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">
                            <button wire:click="toggleActive({{ $section['id'] }})" 
                                class="px-3 py-1 rounded text-xs {{ $section['is_active'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $section['is_active'] ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <button wire:click="edit({{ $section['id'] }})" class="text-blue-600 hover:text-blue-900">
                                Edit
                            </button>
                            <button wire:click="delete({{ $section['id'] }})" 
                                onclick="return confirm('Are you sure?')"
                                class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No sections found. Click "Add Section" to create one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeModal">
            <div class="bg-white rounded-lg p-6 max-w-2xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
                <h2 class="text-xl font-bold mb-4">
                    {{ $editingSection ? 'Edit Section' : 'Add Section' }}
                </h2>

                <form wire:submit.prevent="save">
                    <div class="space-y-4">
                        <!-- Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Section Type</label>
                            <select wire:model="type" class="w-full border border-gray-300 rounded-lg px-3 py-2" {{ $editingSection ? 'disabled' : '' }}>
                                @foreach($sectionTypes as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title (optional)</label>
                            <input type="text" wire:model="title" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        </div>

                        <!-- Order -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Display Order</label>
                            <input type="number" wire:model="order" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        </div>

                        <!-- Active Status -->
                        <div class="flex items-center">
                            <input type="checkbox" wire:model="is_active" id="is_active" class="mr-2">
                            <label for="is_active" class="text-sm font-medium text-gray-700">Active</label>
                        </div>

                        <!-- Content (JSON) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Content (JSON format)
                                <span class="text-xs text-gray-500">- See documentation for section-specific fields</span>
                            </label>
                            <textarea wire:model="content" rows="6" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 font-mono text-sm"
                                placeholder='{"key": "value"}'></textarea>
                        </div>

                        <!-- Rules (JSON) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Visibility Rules (JSON, optional)
                            </label>
                            <textarea wire:model="rules" rows="4" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 font-mono text-sm"
                                placeholder='{"devices": ["mobile", "desktop"]}'></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" wire:click="closeModal" 
                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            {{ $editingSection ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
