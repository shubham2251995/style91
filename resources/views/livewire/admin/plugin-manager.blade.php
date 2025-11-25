<div>
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
                        <button wire:click="toggle('{{ $plugin['key'] }}')" 
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-brand-accent focus:ring-offset-2 focus:ring-offset-black {{ $plugin['active'] ? 'bg-brand-accent' : 'bg-gray-700' }}">
                            <span class="sr-only">Enable {{ $plugin['name'] }}</span>
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $plugin['active'] ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
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
