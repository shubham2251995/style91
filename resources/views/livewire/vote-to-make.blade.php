<div class="min-h-screen bg-gray-900 pt-24 pb-12 px-4">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-black text-white mb-8">VOTE-TO-MAKE</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($proposals as $prop)
                <div class="bg-black border border-white/10 rounded-2xl overflow-hidden group">
                    <div class="relative aspect-video">
                        <img src="{{ $prop['image'] }}" class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition-opacity">
                        <div class="absolute bottom-4 left-4">
                            <h3 class="text-2xl font-bold text-white">{{ $prop['title'] }}</h3>
                        </div>
                    </div>
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm">Current Votes</p>
                            <p class="text-3xl font-mono text-white">{{ $prop['votes'] }}</p>
                        </div>
                        <button wire:click="vote({{ $prop['id'] }})" class="bg-white text-black font-bold px-8 py-3 rounded-lg hover:bg-gray-200 transition-colors">
                            VOTE
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
