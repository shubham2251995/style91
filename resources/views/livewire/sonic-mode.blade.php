<div 
    class="fixed bottom-24 right-4 z-40"
    x-data="{ 
        playing: @entangle('isPlaying'),
        audio: null,
        init() {
            this.audio = new Audio('{{ $tracks[0]['url'] }}');
            this.audio.loop = true;
            $wire.on('toggleAudio', ({ isPlaying }) => {
                if (isPlaying) this.audio.play();
                else this.audio.pause();
            });
        }
    }"
>
    <button 
        wire:click="toggle"
        class="w-12 h-12 rounded-full bg-black/80 backdrop-blur border border-white/20 flex items-center justify-center text-white hover:scale-110 transition-transform shadow-lg group"
    >
        <div class="relative w-5 h-5 flex items-center justify-center gap-0.5" :class="{ 'animate-pulse': playing }">
            <div class="w-1 bg-brand-accent rounded-full transition-all duration-300" :style="playing ? 'height: 100%' : 'height: 40%'"></div>
            <div class="w-1 bg-brand-accent rounded-full transition-all duration-300 delay-75" :style="playing ? 'height: 80%' : 'height: 60%'"></div>
            <div class="w-1 bg-brand-accent rounded-full transition-all duration-300 delay-150" :style="playing ? 'height: 60%' : 'height: 40%'"></div>
        </div>
        
        <!-- Tooltip -->
        <div class="absolute right-full mr-3 bg-black text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
            Sonic Mode
        </div>
    </button>
</div>
