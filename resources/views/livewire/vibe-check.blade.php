<div class="fixed bottom-4 right-4 z-40">
    <div x-data="{ open: false }" class="relative">
        <button 
            @click="open = !open"
            class="w-10 h-10 rounded-full bg-white text-black flex items-center justify-center shadow-lg hover:scale-110 transition-transform"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.85 6.361a15.996 15.996 0 00-4.647 4.763m0 0a15.998 15.998 0 01-3.408 1.618m0 0a15.999 15.999 0 001.618 3.408m0 0a15.999 15.999 0 01-3.408 1.618" />
            </svg>
        </button>

        <div 
            x-show="open" 
            @click.away="open = false"
            class="absolute bottom-full right-0 mb-4 w-48 bg-black border border-white/20 rounded-xl overflow-hidden shadow-2xl"
            x-transition
        >
            <div class="p-3 border-b border-white/10">
                <p class="text-xs font-bold text-gray-400 uppercase">Vibe Check</p>
            </div>
            <div class="p-2 space-y-1">
                <button wire:click="setTheme('bewakoof')" class="w-full text-left px-3 py-2 rounded hover:bg-white/10 text-sm text-white flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-[#FDD835]"></div> Bewakoof (Yellow)
                </button>
                <button wire:click="setTheme('veirdo')" class="w-full text-left px-3 py-2 rounded hover:bg-white/10 text-sm text-white flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-[#CCFF00]"></div> Veirdo (Acid)
                </button>
                <button wire:click="setTheme('default')" class="w-full text-left px-3 py-2 rounded hover:bg-white/10 text-sm text-white flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-500"></div> Default (Blue)
                </button>
            </div>
        </div>
    </div>
</div>
