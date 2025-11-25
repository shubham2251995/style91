<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Header & Footer Manager</h1>
        <button wire:click="save" class="bg-brand-accent text-brand-dark px-4 py-2 rounded-lg font-bold hover:bg-yellow-400 transition">
            Save Changes
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Header Management -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Header Navigation</h2>
                <button wire:click="addHeaderLink" class="text-sm bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200">
                    + Add Link
                </button>
            </div>
            
            <div class="space-y-4">
                @foreach($headerLinks as $index => $link)
                    <div class="flex gap-4 items-start bg-gray-50 p-4 rounded-lg">
                        <div class="flex-1 grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Label</label>
                                <input type="text" wire:model="headerLinks.{{ $index }}.label" class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-accent focus:ring focus:ring-brand-accent focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">URL / Route</label>
                                <input type="text" wire:model="headerLinks.{{ $index }}.url" class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-accent focus:ring focus:ring-brand-accent focus:ring-opacity-50">
                            </div>
                        </div>
                        <button wire:click="removeHeaderLink({{ $index }})" class="text-red-500 hover:text-red-700 mt-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Footer Management -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Footer Columns</h2>
                <button wire:click="addFooterColumn" class="text-sm bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200">
                    + Add Column
                </button>
            </div>

            <div class="space-y-6">
                @foreach($footerColumns as $colIndex => $column)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <div class="w-full max-w-xs">
                                <label class="block text-xs font-bold text-gray-500 mb-1">Column Title</label>
                                <input type="text" wire:model="footerColumns.{{ $colIndex }}.title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-accent focus:ring focus:ring-brand-accent focus:ring-opacity-50 font-bold">
                            </div>
                            <button wire:click="removeFooterColumn({{ $colIndex }})" class="text-red-500 text-xs hover:text-red-700">Remove Column</button>
                        </div>

                        <div class="space-y-2 pl-4 border-l-2 border-gray-200">
                            @foreach($column['links'] as $linkIndex => $link)
                                <div class="flex gap-2 items-center">
                                    <input type="text" wire:model="footerColumns.{{ $colIndex }}.links.{{ $linkIndex }}.label" placeholder="Label" class="w-1/3 text-sm border-gray-300 rounded-md shadow-sm">
                                    <input type="text" wire:model="footerColumns.{{ $colIndex }}.links.{{ $linkIndex }}.url" placeholder="URL" class="w-1/2 text-sm border-gray-300 rounded-md shadow-sm">
                                    <button wire:click="removeFooterLink({{ $colIndex }}, {{ $linkIndex }})" class="text-red-400 hover:text-red-600">
                                        &times;
                                    </button>
                                </div>
                            @endforeach
                            <button wire:click="addFooterLink({{ $colIndex }})" class="text-xs text-brand-accent font-bold mt-2 hover:underline">
                                + Add Link
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
