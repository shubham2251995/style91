<div 
    x-data="{ 
        keys: [], 
        konami: ['ArrowUp','ArrowUp','ArrowDown','ArrowDown','ArrowLeft','ArrowRight','ArrowLeft','ArrowRight','b','a'],
        check(e) {
            this.keys.push(e.key);
            if (this.keys.length > this.konami.length) {
                this.keys.shift();
            }
            if (JSON.stringify(this.keys) === JSON.stringify(this.konami)) {
                $wire.dispatch('unlockStealthReward');
                this.keys = [];
            }
        }
    }"
    @keydown.window="check($event)"
>
    @if($showPopup)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm p-4">
            <div class="bg-gray-900 border-2 border-green-500 rounded-xl p-8 max-w-md w-full text-center relative overflow-hidden">
                <!-- Glitch effect overlay -->
                <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://media.giphy.com/media/oEI9uBYSzLpBK/giphy.gif'); background-size: cover;"></div>
                
                <h2 class="text-3xl font-black text-green-500 mb-4 font-mono tracking-tighter">SYSTEM HACKED</h2>
                <p class="text-gray-300 mb-6">You found the secret entrance. Here's your reward.</p>
                
                <div class="bg-black border border-green-500/50 p-4 rounded-lg mb-6">
                    <p class="text-xs text-green-500/70 uppercase mb-1">Discount Code</p>
                    <p class="text-2xl font-mono font-bold text-white tracking-widest select-all">{{ $code }}</p>
                </div>

                <button wire:click="close" class="bg-green-600 hover:bg-green-500 text-black font-bold py-3 px-8 rounded-full transition-colors w-full">
                    CLAIM & EXIT
                </button>
            </div>
        </div>
    @endif
</div>
