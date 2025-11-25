<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Theme Manager</h2>
            <button wire:click="create" class="bg-brand-dark text-white px-4 py-2 rounded-lg hover:bg-brand-accent hover:text-brand-dark transition-colors">
                Create New Theme
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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($themes as $theme)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden {{ $theme->is_active ? 'ring-2 ring-brand-accent' : '' }}">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-gray-900">{{ $theme->name }}</h3>
                        @if($theme->is_active)
                            <span class="px-2 py-1 bg-brand-accent text-brand-black text-xs font-bold rounded">ACTIVE</span>
                        @endif
                    </div>

                    <div class="space-y-3 mb-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500">Colors</p>
                            <div class="flex gap-2 mt-1">
                                <div class="w-8 h-8 rounded border" style="background-color: {{ $theme->colors['primary'] ?? '#FFE600' }}"></div>
                                <div class="w-8 h-8 rounded border" style="background-color: {{ $theme->colors['secondary'] ?? '#0a0a0a' }}"></div>
                                <div class="w-8 h-8 rounded border" style="background-color: {{ $theme->colors['accent'] ?? '#FFE600' }}"></div>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500">Fonts</p>
                            <p class="text-sm text-gray-700">{{ $theme->fonts['heading'] ?? 'Outfit' }} / {{ $theme->fonts['body'] ?? 'Outfit' }}</p>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button wire:click="edit({{ $theme->id }})" class="flex-1 bg-gray-100 text-gray-700 px-3 py-2 rounded-lg text-sm hover:bg-gray-200">
                            Edit
                        </button>
                        @if(!$theme->is_active)
                            <button wire:click="activate({{ $theme->id }})" class="flex-1 bg-brand-accent text-brand-black px-3 py-2 rounded-lg text-sm font-bold hover:bg-brand-dark hover:text-white">
                                Activate
                            </button>
                            <button wire:click="delete({{ $theme->id }})" class="bg-red-100 text-red-700 px-3 py-2 rounded-lg text-sm hover:bg-red-200" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">
                                Delete
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($isModalOpen)
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                            {{ $themeId ? 'Edit Theme' : 'Create Theme' }}
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Theme Name</label>
                                <input type="text" wire:model="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Primary Color</label>
                                    <div class="flex items-center gap-2 mt-1">
                                        <input type="color" wire:model.live="primaryColor" class="h-10 w-20 border-gray-300 rounded">
                                        <span class="text-sm font-mono">{{ $primaryColor }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Secondary Color</label>
                                    <div class="flex items-center gap-2 mt-1">
                                        <input type="color" wire:model.live="secondaryColor" class="h-10 w-20 border-gray-300 rounded">
                                        <span class="text-sm font-mono">{{ $secondaryColor }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Accent Color</label>
                                    <div class="flex items-center gap-2 mt-1">
                                        <input type="color" wire:model.live="accentColor" class="h-10 w-20 border-gray-300 rounded">
                                        <span class="text-sm font-mono">{{ $accentColor }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Background</label>
                                    <div class="flex items-center gap-2 mt-1">
                                        <input type="color" wire:model.live="backgroundColor" class="h-10 w-20 border-gray-300 rounded">
                                        <span class="text-sm font-mono">{{ $backgroundColor }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Text Color</label>
                                    <div class="flex items-center gap-2 mt-1">
                                        <input type="color" wire:model.live="textColor" class="h-10 w-20 border-gray-300 rounded">
                                        <span class="text-sm font-mono">{{ $textColor }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Heading Font</label>
                                    <select wire:model="headingFont" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                        <option value="Outfit">Outfit</option>
                                        <option value="Inter">Inter</option>
                                        <option value="Roboto">Roboto</option>
                                        <option value="Poppins">Poppins</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Body Font</label>
                                    <select wire:model="bodyFont" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                        <option value="Outfit">Outfit</option>
                                        <option value="Inter">Inter</option>
                                        <option value="Roboto">Roboto</option>
                                        <option value="Poppins">Poppins</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Border Radius</label>
                                    <select wire:model="borderRadius" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                        <option value="0px">None (Sharp)</option>
                                        <option value="4px">Small</option>
                                        <option value="8px">Medium</option>
                                        <option value="16px">Large</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Shadow Intensity</label>
                                    <select wire:model="shadowIntensity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-dark focus:border-brand-dark sm:text-sm">
                                        <option value="none">None</option>
                                        <option value="small">Small</option>
                                        <option value="medium">Medium</option>
                                        <option value="large">Large</option>
                                    </select>
                                </div>
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
