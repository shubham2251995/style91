<div>
    <h2 class="text-xl font-bold mb-4 text-brand-dark">Referral Program</h2>
    
    <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-6 mb-8">
        <h3 class="text-lg font-bold text-indigo-900 mb-2">Invite Friends & Earn</h3>
        <p class="text-indigo-700 mb-4">Share your unique link and earn rewards when your friends sign up and purchase!</p>
        
        <div class="flex gap-2 mb-4">
            <input type="text" value="{{ $referralLink }}" class="flex-1 border border-indigo-200 rounded px-3 py-2 bg-white text-gray-600" readonly>
            <button onclick="navigator.clipboard.writeText('{{ $referralLink }}')" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Copy</button>
        </div>

        <form wire:submit.prevent="sendInvite" class="flex gap-2">
            <input type="email" wire:model="email" placeholder="Enter friend's email" class="flex-1 border border-indigo-200 rounded px-3 py-2">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Invite</button>
        </form>
        @if (session()->has('message'))
            <div class="text-green-600 text-sm mt-2">{{ session('message') }}</div>
        @endif
    </div>

    <h3 class="font-bold text-gray-800 mb-4">Your Referrals</h3>
    @if($referrals->count() > 0)
        <div class="space-y-3">
            @foreach($referrals as $referral)
                <div class="flex justify-between items-center border p-3 rounded">
                    <div>
                        <div class="font-medium">{{ $referral->email ?? $referral->referredUser->email ?? 'Unknown' }}</div>
                        <div class="text-xs text-gray-500">{{ $referral->created_at->format('M d, Y') }}</div>
                    </div>
                    <div>
                        <span class="px-2 py-1 rounded text-xs font-bold
                            {{ $referral->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($referral->status) }}
                        </span>
                        @if($referral->reward_amount > 0)
                            <span class="ml-2 text-green-600 font-bold">+₹{{ $referral->reward_amount }}</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">No referrals yet. Start inviting!</p>
    @endif
</div>
