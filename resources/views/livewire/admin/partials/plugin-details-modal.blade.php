{{-- Details Modal --}}
@if($showDetailsModal && $selectedPlugin)
<div class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-900/75" wire:click="closeDetailsModal"></div>
        
        <div class="inline-block align-bottom bg-gray-800 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-brand-accent/30">
            <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4 border-b border-white/10">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-3">
                        @if(!empty($selectedPlugin['icon']))
                            <span class="text-4xl">{{ $selectedPlugin['icon'] }}</span>
                        @endif
                        <div>
                            <h3 class="text-2xl font-bold text-white">{{ $selectedPlugin['name'] }}</h3>
                            <p class="text-sm text-gray-400">{{ $selectedPlugin['key'] }}</p>
                        </div>
                    </div>
                    <button wire:click="closeDetailsModal" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="bg-gray-800 px-6 py-6 space-y-6">
                {{-- Description --}}
                @if(!empty($selectedPlugin['description']))
                    <div>
                        <h4 class="text-sm font-bold text-brand-accent uppercase tracking-wider mb-2">Description</h4>
                        <p class="text-gray-300">{{ $selectedPlugin['description'] }}</p>
                    </div>
                @endif

                {{-- Features --}}
                @if(!empty($selectedPlugin['features']))
                    <div>
                        <h4 class="text-sm font-bold text-brand-accent uppercase tracking-wider mb-3">✨ Key Features</h4>
                        <ul class="space-y-2">
                            @foreach($selectedPlugin['features'] as $feature)
                                <li class="flex items-start gap-2 text-gray-300">
                                    <svg class="w-5 h-5 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Locations --}}
                @if(!empty($selectedPlugin['locations']))
                    <div>
                        <h4 class="text-sm font-bold text-brand-accent uppercase tracking-wider mb-3">📍 Where It Works</h4>
                        <div class="space-y-2">
                            @foreach($selectedPlugin['locations'] as $location)
                                <div class="flex items-start gap-2 text-gray-300">
                                    <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $location }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Status Badge --}}
                <div class="flex items-center justify-between pt-4 border-t border-white/10">
                    <span class="text-sm text-gray-400">Current Status:</span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $selectedPlugin['active'] ?? false ? 'bg-green-500/20 text-green-400 border border-green-500/50' : 'bg-gray-700 text-gray-400 border border-gray-600' }}">
                        {{ $selectedPlugin['active'] ?? false ? '✓ Active' : '○ Inactive' }}
                    </span>
                </div>
            </div>

            <div class="bg-gray-900 px-6 py-4 flex justify-end gap-3">
                <button wire:click="closeDetailsModal" class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition">
                    Close
                </button>
                <button wire:click="toggle('{{ $selectedPlugin['key'] ?? '' }}')" 
                        class="px-4 py-2 rounded-lg font-bold transition {{ $selectedPlugin['active'] ?? false ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-brand-accent hover:bg-blue-500 text-black' }}">
                    {{ $selectedPlugin['active'] ?? false ? 'Deactivate' : 'Activate' }} Plugin
                </button>
            </div>
        </div>
    </div>
</div>
@endif
