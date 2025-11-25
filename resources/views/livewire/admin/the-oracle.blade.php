<div class="p-6 h-full flex flex-col">
    <div class="text-center mb-8">
        <h2 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600 mb-2">THE ORACLE</h2>
        <p class="text-gray-400">AI-Powered Business Intelligence</p>
    </div>

    <div class="flex-1 overflow-y-auto mb-6 space-y-4">
        @if($answer)
            <div class="bg-purple-500/10 border border-purple-500/20 p-6 rounded-xl animate-fade-in-up">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center text-white text-xl">🔮</div>
                    <div>
                        <p class="text-white text-lg leading-relaxed">{{ $answer }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="relative">
        <form wire:submit.prevent="ask">
            <input 
                wire:model="question" 
                type="text" 
                class="w-full bg-black border border-white/20 rounded-full py-4 px-6 text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all"
                placeholder="Ask anything about your business..."
            >
            <button 
                type="submit" 
                class="absolute right-2 top-2 bg-purple-600 text-white p-2 rounded-full hover:bg-purple-500 transition-colors"
                wire:loading.attr="disabled"
            >
                <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                </svg>
                <svg wire:loading class="animate-spin w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </form>
    </div>
</div>
