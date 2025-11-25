<div 
    x-data="{ 
        open: @entangle('isOpen'),
        toggle() { this.open = !this.open }
    }"
    @keydown.window.cmd.k.prevent="toggle()"
    @keydown.window.ctrl.k.prevent="toggle()"
    @keydown.escape.window="open = false"
    class="relative z-50"
    style="display: none;"
    x-show="open"
>
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" x-show="open" x-transition.opacity></div>

    <!-- Search Modal -->
    <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
        <div 
            class="mx-auto max-w-2xl transform divide-y divide-white/10 overflow-hidden rounded-xl bg-black border border-white/20 shadow-2xl transition-all"
            @click.away="open = false"
        >
            <div class="relative">
                <svg class="pointer-events-none absolute left-4 top-3.5 h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
                <input 
                    type="text" 
                    wire:model.live="query"
                    class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-white placeholder:text-gray-500 focus:ring-0 sm:text-sm" 
                    placeholder="Search the archive... (Cmd+K)"
                    autofocus
                >
            </div>

            @if(count($results) > 0)
                <ul class="max-h-96 scroll-py-3 overflow-y-auto p-3">
                    @foreach($results as $result)
                    <li class="group flex cursor-default select-none rounded-xl p-3 hover:bg-white/10 transition-colors">
                        <a href="{{ route('product', $result->slug) }}" class="flex items-center gap-4 w-full">
                            <div class="h-10 w-10 flex-none rounded-lg bg-gray-800 overflow-hidden">
                                <img src="{{ $result->image_url }}" class="h-full w-full object-cover">
                            </div>
                            <div class="flex-auto">
                                <p class="text-sm font-semibold text-white">{{ $result->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $result->category }}</p>
                            </div>
                            <div class="flex-none">
                                <span class="text-brand-accent font-mono text-sm">${{ $result->price }}</span>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            @endif

            @if(strlen($query) >= 2 && count($results) === 0)
                <div class="px-6 py-14 text-center text-sm sm:px-14">
                    <p class="mt-4 font-semibold text-gray-400">No results found</p>
                    <p class="mt-2 text-gray-500">We couldn't find anything matching that term. Try something else.</p>
                </div>
            @endif
            
            <div class="flex flex-wrap items-center bg-white/5 px-4 py-2.5 text-xs text-gray-400 border-t border-white/10">
                <span class="mx-1">Protip:</span>
                <kbd class="mx-1 flex h-5 w-5 items-center justify-center rounded border border-gray-600 bg-gray-800 font-semibold text-white"><span class="text-xs">↵</span></kbd>
                <span class="mx-1">to select</span>
                <kbd class="mx-1 flex h-5 w-5 items-center justify-center rounded border border-gray-600 bg-gray-800 font-semibold text-white"><span class="text-xs">esc</span></kbd>
                <span class="mx-1">to close</span>
            </div>
        </div>
    </div>
</div>
