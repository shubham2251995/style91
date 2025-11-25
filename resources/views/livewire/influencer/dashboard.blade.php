<div class="min-h-screen bg-black text-white p-6 pb-24">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-black tracking-tighter">AMBASSADOR</h1>
                <p class="text-gray-400 text-sm">Welcome back, {{ auth()->user()->name }}</p>
            </div>
            <div class="bg-white/10 px-3 py-1 rounded-full text-xs font-bold {{ $influencer->status === 'active' ? 'text-green-400' : 'text-yellow-400' }}">
                {{ strtoupper($influencer->status) }}
            </div>
        </div>

        @if($influencer->status === 'pending')
            <div class="bg-yellow-500/10 border border-yellow-500/20 p-6 rounded-xl mb-8 text-center">
                <p class="text-yellow-500 font-bold mb-2">Application Under Review</p>
                <p class="text-sm text-gray-400">We are reviewing your profile. You will be notified once approved.</p>
            </div>
        @else
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="bg-gray-900 p-4 rounded-xl border border-white/10">
                    <p class="text-gray-400 text-xs mb-1">Total Earnings</p>
                    <p class="text-2xl font-mono font-bold text-green-400">₹{{ number_format($influencer->earnings, 2) }}</p>
                </div>
                <div class="bg-gray-900 p-4 rounded-xl border border-white/10">
                    <p class="text-gray-400 text-xs mb-1">Commission Rate</p>
                    <p class="text-2xl font-mono font-bold text-brand-accent">{{ $influencer->commission_rate }}%</p>
                </div>
            </div>

            <!-- Referral Link -->
            <div class="bg-gray-900 p-6 rounded-xl border border-white/10 mb-8">
                <h3 class="font-bold mb-4">Your Referral Link</h3>
                <div class="flex gap-2">
                    <input type="text" readonly value="{{ url('/?ref=' . $influencer->code) }}" class="w-full bg-black border border-white/20 rounded p-3 text-sm text-gray-400 font-mono">
                    <button onclick="navigator.clipboard.writeText('{{ url('/?ref=' . $influencer->code) }}')" class="bg-brand-accent text-black px-4 rounded font-bold hover:bg-white transition-colors">
                        COPY
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-2">Share this link to earn commissions on every sale.</p>
            </div>
        @endif
    </div>
</div>
