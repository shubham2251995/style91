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
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-bold text-lg">{{ $plugin['name'] }}</h4>
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
                            
                            {{-- Edit Button --}}
                            <a href="{{ route('admin.plugin.edit', $plugin['key']) }}" class="ml-2 text-gray-400 hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 font-mono">{{ $plugin['key'] }}</p>
                    
                    @if($plugin['active'])
                        <div class="mt-3 flex items-center gap-2 text-xs text-green-400">
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                            ACTIVE
                        </div>
                    @else
                        <div class="mt-3 flex items-center gap-2 text-xs text-gray-600">
                            <span class="w-2 h-2 rounded-full bg-gray-600"></span>
                            OFFLINE
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </section>
        @endforeach
    </div>
</div>
