<div class="min-h-screen bg-black text-white p-6 pb-24">
    <div class="max-w-md mx-auto">
        <h1 class="text-3xl font-black tracking-tighter mb-8 text-brand-accent">FAME & FORTUNE</h1>

        <div class="space-y-4">
            @foreach($influencers as $influencer)
            <div class="bg-gray-900 rounded-xl p-4 border border-white/10">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-bold text-lg">{{ $influencer->user->name }}</h3>
                        <p class="text-sm text-gray-400">{{ $influencer->user->email }}</p>
                    </div>
                    <span class="px-2 py-1 rounded text-xs font-bold {{ $influencer->status === 'active' ? 'bg-green-500/20 text-green-500' : ($influencer->status === 'pending' ? 'bg-yellow-500/20 text-yellow-500' : 'bg-red-500/20 text-red-500') }}">
                        {{ strtoupper($influencer->status) }}
                    </span>
                </div>

                <div class="flex justify-between items-center bg-black/50 p-3 rounded mb-4">
                    <div>
                        <p class="text-xs text-gray-500">Code</p>
                        <p class="font-mono font-bold">{{ $influencer->code }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Earnings</p>
                        <p class="font-mono font-bold text-green-400">₹{{ number_format($influencer->earnings, 2) }}</p>
                    </div>
                </div>

                @if($influencer->status === 'pending')
                <div class="flex gap-2">
                    <button wire:click="approve({{ $influencer->id }})" class="flex-1 bg-green-600 text-white py-2 rounded font-bold text-xs hover:bg-green-500">APPROVE</button>
                    <button wire:click="reject({{ $influencer->id }})" class="flex-1 bg-red-600 text-white py-2 rounded font-bold text-xs hover:bg-red-500">REJECT</button>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $influencers->links() }}
        </div>
    </div>
</div>
