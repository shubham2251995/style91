<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-white flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
        Dead Stock Reaper
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($deadStock as $item)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 relative overflow-hidden group hover:border-red-500/50 transition-colors">
                <div class="absolute top-0 right-0 bg-gray-800 text-xs px-2 py-1 rounded-bl-lg text-gray-400">
                    {{ $item->days_stagnant }} Days Stagnant
                </div>
                
                <div class="flex items-center gap-4 mb-4">
                    <img src="{{ $item->image_url }}" class="w-16 h-16 object-cover rounded-lg grayscale group-hover:grayscale-0 transition-all">
                    <div>
                        <h3 class="font-bold text-white">{{ $item->name }}</h3>
                        <p class="text-sm text-gray-500">${{ $item->price }}</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <button class="w-full bg-red-600/20 text-red-500 hover:bg-red-600 hover:text-white py-2 rounded-lg text-sm font-bold transition-colors">
                        Slash Price (-30%)
                    </button>
                    <button class="w-full bg-white/5 text-gray-400 hover:bg-white/10 py-2 rounded-lg text-sm font-bold transition-colors">
                        Bundle It
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
