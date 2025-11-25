<div 
    class="fixed bottom-4 left-4 z-50"
    x-data="{ 
        listening: @entangle('isListening'),
        recognition: null,
        init() {
            if ('webkitSpeechRecognition' in window) {
                this.recognition = new webkitSpeechRecognition();
                this.recognition.continuous = false;
                this.recognition.lang = 'en-US';
                
                this.recognition.onresult = (event) => {
                    const transcript = event.results[0][0].transcript;
                    $wire.processCommand(transcript);
                    this.listening = false;
                };

                $wire.on('toggleVoice', ({ listening }) => {
                    if (listening) this.recognition.start();
                    else this.recognition.stop();
                });
            }
        }
    }"
>
    <button 
        wire:click="toggleListening"
        class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all duration-300"
        :class="listening ? 'bg-red-600 animate-pulse scale-110' : 'bg-black border border-white/20 hover:scale-105'"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z" />
        </svg>
    </button>
    
    @if($transcript)
        <div class="absolute bottom-full left-0 mb-2 bg-black text-white text-xs px-3 py-1 rounded whitespace-nowrap border border-white/10">
            "{{ $transcript }}"
        </div>
    @endif
</div>
