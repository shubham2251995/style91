<div class="min-h-screen flex items-center justify-center bg-black text-white">
    <div class="text-center max-w-md px-6">
        <h1 class="text-4xl font-black mb-6 tracking-tighter">THE GUILD</h1>
        
        @if($hasToken)
            <div class="bg-green-500/10 border border-green-500/20 p-8 rounded-2xl animate-fade-in">
                <div class="text-6xl mb-4">🔓</div>
                <h2 class="text-2xl font-bold text-green-500 mb-2">ACCESS GRANTED</h2>
                <p class="text-gray-400 mb-6">Welcome, Holder #8821.</p>
                <a href="{{ route('vote') }}" class="block w-full bg-green-600 text-black font-bold py-3 rounded-lg hover:bg-green-500 transition-colors">
                    Enter DAO
                </a>
            </div>
        @else
            <div class="bg-white/5 border border-white/10 p-8 rounded-2xl">
                <div class="text-6xl mb-4">🔒</div>
                <h2 class="text-2xl font-bold mb-2">TOKEN GATED</h2>
                <p class="text-gray-400 mb-6">You need a US7 Genesis Pass to enter.</p>
                <button wire:click="checkWallet" class="w-full bg-brand-accent text-white font-bold py-3 rounded-lg hover:bg-blue-600 transition-colors">
                    Connect Wallet
                </button>
            </div>
        @endif
    </div>
</div>
