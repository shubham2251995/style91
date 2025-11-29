<div>
    {{-- Success Message --}}
    @if($successMessage)
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="mb-6 bg-green-500/10 border border-green-500/50 rounded-xl p-4 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-green-400 font-medium">{{ $successMessage }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold">Plugin Architecture</h2>
        <div class="text-sm text-gray-400">
            <span class="text-brand-accent font-bold">{{ collect($groupedPlugins)->flatten(1)->where('active', true)->count() }}</span> Active Modules
        </div>
    </div>

    <div class="space-y-8">
        @foreach($groupedPlugins as $groupKey => $plugins)
        <section>
            <h3 class="text-xl font-bold mb-4 text-brand-white/80 border-b border-white/10 pb-2">
                <span class="text-brand-accent mr-2">{{ $groupKey }}.</span> {{ $groupNames[$groupKey] ?? 'Unknown Group' }}
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($plugins as $plugin)
                <div class="bg-white/5 border {{ $plugin['active'] ? 'border-brand-accent/50 bg-brand-accent/5' : 'border-white/10' }} rounded-xl p-4 transition-all hover:border-white/30">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center gap-2">
                            @if(!empty($plugin['icon']))
                                <span class="text-2xl">{{ $plugin['icon'] }}</span>
                            @endif
                            <h4 class="font-bold text-lg">{{ $plugin['name'] }}</h4>
                        </div>
                        <div class="relative">
                            {{-- Loading Spinner --}}
                            <div wire:loading wire:target="toggle('{{ $plugin['key'] }}')" 
                                 class="absolute inset-0 flex items-center justify-center bg-black/50 rounded-full z-10">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            
                            {{-- Toggle Button --}}
                            <button wire:click="toggle('{{ $plugin['key'] }}')" 
                                    wire:loading.attr="disabled"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-brand-accent focus:ring-offset-2 focus:ring-offset-black {{ $plugin['active'] ? 'bg-brand-accent' : 'bg-gray-700' }}">
                                <span class="sr-only">Enable {{ $plugin['name'] }}</span>
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200 {{ $plugin['active'] ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                            
                            {{-- Edit Button - Opens inline config if available --}}
                            @if($plugin['active'] && isset($plugin['config']))
                                <button wire:click="$set('editingPlugin', '{{ $plugin['key'] }}')" class="ml-2 text-gray-400 hover:text-white transition-colors" title="Configure Plugin">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 font-mono mb-2">{{ $plugin['key'] }}</p>
                    
                    @if(!empty($plugin['description']))
                        <p class="text-sm text-gray-400 mb-3 line-clamp-2">{{ $plugin['description'] }}</p>
                    @endif

                    <div class="flex items-center justify-between">
                        @if(!empty($plugin['features']) || !empty($plugin['locations']))
                            <button wire:click="viewDetails('{{ $plugin['key'] }}')" 
                                    class="text-xs text-brand-accent hover:text-blue-400 font-bold uppercase tracking-wider flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                View Details
                            </button>
                        @endif
                        
                        @if($plugin['active'])
                            <div class="flex items-center gap-2 text-xs text-green-400">
                                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                                ACTIVE
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <span class="w-2 h-2 rounded-full bg-gray-600"></span>
                                OFFLINE
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endforeach
    </div>

    @include('livewire.admin.partials.plugin-details-modal')
</div>
