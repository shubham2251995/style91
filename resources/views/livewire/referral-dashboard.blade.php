<div class="space-y-6">
    <!-- Referral Code Card -->
    <div class="bg-gradient-to-r from-brand-accent to-yellow-400 rounded-2xl p-6 text-brand-dark">
        <h3 class="text-lg font-bold mb-2">Your Referral Code</h3>
        <div class="flex items-center gap-3 bg-white/20 backdrop-blur-sm rounded-lg p-4">
            <code class="text-2xl font-black flex-1">{{ $referralCode }}</code>
            <button 
                x-data
                @click="navigator.clipboard.writeText('{{ $referralCode }}'); $dispatch('code-copied')"
                class="bg-brand-dark text-brand-accent px-4 py-2 rounded-lg font-bold hover:bg-gray-800 transition"
            >
                COPY
            </button>
        </div>
        <p class="text-sm mt-3 text-brand-dark/80">Share this code with friends and earn rewards when they make their first purchase!</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase font-bold mb-1">Total Referrals</p>
            <p class="text-2xl font-black text-brand-dark">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase font-bold mb-1">Pending</p>
            <p class="text-2xl font-black text-orange-500">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase font-bold mb-1">Completed</p>
            <p class="text-2xl font-black text-green-500">{{ $stats['completed'] }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase font-bold mb-1">Total Earned</p>
            <p class="text-2xl font-black text-brand-accent">${{ number_format($stats['total_earned'], 2) }}</p>
        </div>
    </div>

    <!-- Share Buttons -->
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <h4 class="font-bold text-lg mb-4 text-brand-dark">Share With Friends</h4>
        <div class="flex flex-wrap gap-3">
            <a 
                href="https://wa.me/?text=Use my code {{ $referralCode }} for amazing deals at {{ config('app.name') }}!"
                target="_blank"
                class="flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                WhatsApp
            </a>
            <a 
                href="https://www.facebook.com/sharer.php?u={{ urlencode(route('home')) }}&quote=Use code {{ $referralCode }}"
                target="_blank"
                class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                Facebook
            </a>
            <a 
                href="https://twitter.com/intent/tweet?text=Use code {{ $referralCode }} at {{ config('app.name') }}!"
                target="_blank"
                class="flex items-center gap-2 bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
                Twitter
            </a>
        </div>
    </div>

    <!-- Referral List -->
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <h4 class="font-bold text-lg mb-4 text-brand-dark">Your Referrals</h4>
        
        @if($referrals->count() > 0)
            <div class="space-y-3">
                @foreach($referrals as $referral)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <p class="font-bold text-brand-dark">
                            {{ $referral->referred ? $referral->referred->name : $referral->referred_email }}
                        </p>
                        <p class="text-xs text-gray-500">{{ $referral->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($referral->status === 'pending')
                            <span class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded">Pending</span>
                        @elseif($referral->status === 'completed')
                            <span class="px-3 py-1 bg-green-100 text-green-600 text-xs font-bold rounded">Completed</span>
                        @else
                            <span class="px-3 py-1 bg-brand-accent/20 text-brand-dark text-xs font-bold rounded">Rewarded</span>
                        @endif
                        @if($referral->status === 'rewarded')
                            <span class="text-brand-accent font-bold">+${{ number_format($referral->referrer_reward, 2) }}</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 mb-2">No referrals yet</p>
                <p class="text-sm text-gray-400">Share your code to start earning rewards!</p>
            </div>
        @endif
    </div>

    <!-- Toast notification for copy -->
    <div 
        x-data="{ show: false }"
        @code-copied.window="show = true; setTimeout(() => show = false, 2000)"
        x-show="show"
        x-transition
        class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg"
        style="display: none;"
    >
        ✓ Code copied to clipboard!
    </div>
</div>
