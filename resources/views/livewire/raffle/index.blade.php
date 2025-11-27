<div class="min-h-screen bg-black text-white py-20 px-4">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl md:text-6xl font-black mb-8 text-center uppercase tracking-tighter">Active Raffles</h1>
        
        @if($raffles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($raffles as $raffle)
                    <div class="bg-gray-900 border border-white/10 rounded-xl overflow-hidden group hover:border-brand-accent transition-colors">
                        <div class="relative aspect-square">
                            <img src="{{ $raffle->product->image_url }}" class="w-full h-full object-cover">
                            <div class="absolute top-4 right-4 bg-brand-accent text-black font-bold px-3 py-1 rounded-full text-xs uppercase">
                                Ends {{ $raffle->end_time->diffForHumans() }}
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $raffle->product->name }}</h3>
                            <p class="text-gray-400 text-sm mb-4">{{ $raffle->description ?? 'Enter for a chance to win!' }}</p>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-brand-accent font-mono">
                                    {{ $raffle->entries_count ?? 0 }} Entries
                                </span>
                                <a href="{{ route('product', $raffle->product->slug) }}" class="bg-white text-black px-6 py-2 rounded-full font-bold text-sm hover:bg-brand-accent transition-colors">
                                    View Product
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="text-6xl mb-4">🎫</div>
                <h2 class="text-2xl font-bold mb-2">No Active Raffles</h2>
                <p class="text-gray-400">Check back later for exclusive drops.</p>
            </div>
        @endif
    </div>
</div>
