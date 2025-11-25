<div class="min-h-screen bg-black text-white p-6 pb-24">
    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black tracking-tighter mb-2 text-brand-accent">THE STYLE CLUB</h1>
            <p class="text-gray-400 text-sm">Unlock exclusive perks as you shop.</p>
        </div>

        <!-- Current Status Card -->
        <div class="bg-gradient-to-br from-gray-900 to-black border border-white/10 rounded-2xl p-8 mb-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-brand-accent/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
            
            <div class="relative z-10 text-center">
                <p class="text-gray-400 text-xs uppercase tracking-widest mb-2">CURRENT STATUS</p>
                <h2 class="text-4xl font-black mb-1" style="color: {{ $currentTier->color ?? '#ffffff' }}">
                    {{ $currentTier->name ?? 'INITIATE' }}
                </h2>
                @if($currentTier)
                    <p class="text-sm font-bold text-green-400">{{ $currentTier->discount_percentage }}% OFF EVERYTHING</p>
                @else
                    <p class="text-sm text-gray-500">No active perks yet.</p>
                @endif
            </div>
        </div>

        <!-- Progress -->
        @if($progress['next_tier'])
            <div class="bg-gray-900 rounded-xl p-6 border border-white/10 mb-8">
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-400">Next Level: <span class="text-white font-bold">{{ $progress['next_tier']->name }}</span></span>
                    <span class="text-brand-accent font-mono">₹{{ number_format($progress['amount_needed']) }} to go</span>
                </div>
                <div class="h-2 bg-black rounded-full overflow-hidden">
                    <div class="h-full bg-brand-accent transition-all duration-1000" style="width: {{ $progress['percentage'] }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-3 text-center">
                    Unlock {{ $progress['next_tier']->discount_percentage }}% OFF when you reach ₹{{ number_format($progress['next_tier']->threshold) }} lifetime spend.
                </p>
            </div>
        @else
            <div class="bg-brand-accent/10 border border-brand-accent/20 p-6 rounded-xl mb-8 text-center">
                <p class="text-brand-accent font-bold">MAXIMUM LEVEL REACHED</p>
                <p class="text-sm text-gray-400">You are a legend. Enjoy your top-tier perks.</p>
            </div>
        @endif

        <!-- All Tiers -->
        <h3 class="font-bold mb-4">Membership Tiers</h3>
        <div class="space-y-3">
            @foreach($tiers as $tier)
                <div class="flex items-center justify-between p-4 rounded-xl border {{ $currentTier && $currentTier->id === $tier->id ? 'border-brand-accent bg-brand-accent/5' : 'border-white/5 bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $tier->color }}"></div>
                        <div>
                            <p class="font-bold">{{ $tier->name }}</p>
                            <p class="text-xs text-gray-500">Spend ₹{{ number_format($tier->threshold) }}+</p>
                        </div>
                    </div>
                    <span class="font-mono font-bold text-sm">{{ $tier->discount_percentage }}% OFF</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
