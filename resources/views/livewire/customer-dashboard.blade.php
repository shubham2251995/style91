<div class="min-h-screen bg-brand-gray pb-24">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 text-brand-dark">MY <span class="text-brand-accent">ACCOUNT</span></h1>

        <!-- Tab Navigation -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="flex border-b border-gray-200 overflow-x-auto">
                <button 
                    wire:click="setTab('orders')"
                    class="px-6 py-4 font-bold text-sm whitespace-nowrap {{ $activeTab === 'orders' ? 'border-b-2 border-brand-accent text-brand-accent' : 'text-gray-600 hover:text-brand-dark' }}"
                >
                    MY ORDERS
                </button>
                <button 
                    wire:click="setTab('wishlist')"
                    class="px-6 py-4 font-bold text-sm whitespace-nowrap {{ $activeTab === 'wishlist' ? 'border-b-2 border-brand-accent text-brand-accent' : 'text-gray-600 hover:text-brand-dark' }}"
                >
                    WISHLIST
                </button>
                <button 
                    wire:click="setTab('addresses')"
                    class="px-6 py-4 font-bold text-sm whitespace-nowrap {{ $activeTab === 'addresses' ? 'border-b-2 border-brand-accent text-brand-accent' : 'text-gray-600 hover:text-brand-dark' }}"
                >
                    ADDRESSES
                </button>
                <button 
                    wire:click="setTab('profile')"
                    class="px-6 py-4 font-bold text-sm whitespace-nowrap {{ $activeTab === 'profile' ? 'border-b-2 border-brand-accent text-brand-accent' : 'text-gray-600 hover:text-brand-dark' }}"
                >
                    PROFILE
                </button>
                <button 
                    wire:click="setTab('referrals')"
                    class="px-6 py-4 font-bold text-sm whitespace-nowrap {{ $activeTab === 'referrals' ? 'border-b-2 border-brand-accent text-brand-accent' : 'text-gray-600 hover:text-brand-dark' }}"
                >
                    REFERRALS
                </button>
                <button 
                    wire:click="setTab('gift-cards')"
                    class="px-6 py-4 font-bold text-sm whitespace-nowrap {{ $activeTab === 'gift-cards' ? 'border-b-2 border-brand-accent text-brand-accent' : 'text-gray-600 hover:text-brand-dark' }}"
                >
                    GIFT CARDS
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            @if($activeTab === 'orders')
                <!-- Orders Tab -->
                <div>
                    <h2 class="text-xl font-bold mb-4 text-brand-dark">Order History</h2>
                    @if($orders->count() > 0)
                        <div class="space-y-4">
                            @foreach($orders as $order)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-brand-accent transition">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="font-bold text-sm text-gray-500">ORDER #{{ $order->id }}</p>
                                        <p class="text-xs text-gray-400">{{ $order->created_at->format('M d, Y') }}</p>
                                        <a href="{{ route('account.order', $order->id) }}" class="text-indigo-600 text-sm hover:underline mt-1 inline-block">View Details</a>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-lg">${{ number_format($order->total, 2) }}</p>
                                        <span class="inline-block px-2 py-1 text-xs font-bold rounded {{ $order->status === 'completed' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                            {{ strtoupper($order->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="border-t border-gray-100 pt-3 text-sm text-gray-600">
                                    {{ $order->items->count() }} item(s) • {{ ucfirst($order->payment_method) }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">No orders yet</p>
                            <a href="{{ route('home') }}" class="inline-block bg-brand-accent text-brand-dark px-6 py-3 rounded-xl font-bold hover:bg-yellow-400 transition">
                                START SHOPPING
                            </a>
                        </div>
                    @endif
                </div>
            @elseif($activeTab === 'wishlist')
                <!-- Wishlist Tab -->
                <livewire:wishlist-index />
            @elseif($activeTab === 'addresses')
                <!-- Addresses Tab -->
                <livewire:address-manager />
            @elseif($activeTab === 'profile')
                <!-- Profile Tab -->
                <div>
                    <h2 class="text-xl font-bold mb-4 text-brand-dark">Profile Information</h2>
                    <div class="space-y-4 max-w-md">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Name</label>
                            <input type="text" value="{{ $user->name }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <input type="email" value="{{ $user->email ?? 'Not set' }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Mobile</label>
                            <input type="text" value="{{ $user->mobile }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Member Since</label>
                            <input type="text" value="{{ $user->created_at->format('F Y') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" readonly>
                        </div>
                    </div>
                </div>
            @elseif($activeTab === 'referrals')
                <!-- Referrals Tab -->
                <livewire:referral-dashboard />
            @elseif($activeTab === 'gift-cards')
                <!-- Gift Cards Tab -->
                <livewire:my-gift-cards />
            @endif
        </div>
    </div>
</div>
