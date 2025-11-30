<div class="space-y-6" wire:poll.{{ $refreshInterval }}ms>
    {{-- Header --}}
    <div>
        <h2 class="text-3xl font-bold flex items-center gap-2">
            <span class="text-4xl">👁️</span>
            God View
        </h2>
        <p class="text-gray-400 mt-1">Real-time system monitoring and analytics</p>
    </div>

    {{-- Real-time Metrics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-green-500/10 to-green-600/5 border border-green-500/20 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center animate-pulse">
                    <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                    </svg>
                </div>
                <span class="text-xs text-green-400 font-bold uppercase">Live</span>
            </div>
            <p class="text-3xl font-bold mb-1">{{ $realtimeMetrics['active_users'] }}</p>
            <p class="text-sm text-gray-400">Active Users (15m)</p>
        </div>

        <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/5 border border-blue-500/20 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                    </svg>
                </div>
                <span class="text-xs text-blue-400 font-bold uppercase">Live</span>
            </div>
            <p class="text-3xl font-bold mb-1">₹{{ number_format($realtimeMetrics['cart_value'], 0) }}</p>
            <p class="text-sm text-gray-400">Active Carts Value</p>
        </div>

        <div class="bg-gradient-to-br from-orange-500/10 to-orange-600/5 border border-orange-500/20 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <span class="text-xs text-orange-400 font-bold uppercase">Live</span>
            </div>
            <p class="text-3xl font-bold mb-1">{{ $realtimeMetrics['pending_orders'] }}</p>
            <p class="text-sm text-gray-400">Pending Orders</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500/10 to-purple-600/5 border border-purple-500/20 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <span class="text-xs text-purple-400 font-bold uppercase">Today</span>
            </div>
            <p class="text-3xl font-bold mb-1">₹{{ number_format($realtimeMetrics['revenue_today'], 0) }}</p>
            <p class="text-sm text-gray-400">Today's Revenue</p>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
            <p class="text-gray-400 text-sm">Total Users</p>
            <p class="text-2xl font-bold mt-1">{{ number_format($stats['total_users']) }}</p>
        </div>
        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
            <p class="text-gray-400 text-sm">Total Orders</p>
            <p class="text-2xl font-bold mt-1">{{ number_format($stats['total_orders']) }}</p>
        </div>
        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
            <p class="text-gray-400 text-sm">Total Products</p>
            <p class="text-2xl font-bold mt-1">{{ number_format($stats['total_products']) }}</p>
        </div>
        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
            <p class="text-gray-400 text-sm">Total Revenue</p>
            <p class="text-2xl font-bold mt-1 text-green-400">₹{{ number_format($stats['total_revenue'], 0) }}</p>
        </div>
        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
            <p class="text-gray-400 text-sm">Avg Order</p>
            <p class="text-2xl font-bold mt-1">₹{{ number_format($stats['avg_order_value'], 0) }}</p>
        </div>
        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
            <p class="text-gray-400 text-sm">Conversion</p>
            <p class="text-2xl font-bold mt-1 text-brand-accent">{{ $stats['conversion_rate'] }}%</p>
        </div>
    </div>

    {{-- System Health --}}
    <div class="bg-white/5 border border-white/10 rounded-xl p-6">
        <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-brand-accent" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd"></path>
            </svg>
            System Health
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($systemHealth as $service => $health)
            <div class="bg-black/30 border border-white/10 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium capitalize">{{ str_replace('_', ' ', $service) }}</p>
                    <span class="w-3 h-3 rounded-full {{ $health['status'] === 'healthy' ? 'bg-green-400' : ($health['status'] === 'warning' ? 'bg-yellow-400' : 'bg-red-400') }} animate-pulse"></span>
                </div>
                @if(isset($health['percent']))
                    <p class="text-xs text-gray-400">{{ $health['used'] }} / {{ $health['total'] }}</p>
                    <div class="mt-2 bg-gray-700 rounded-full h-2">
                        <div class="bg-brand-accent h-2 rounded-full" style="width: {{ $health['percent'] }}%"></div>
                    </div>
                @else
                    <p class="text-xs text-gray-400">{{ $health['message'] }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Revenue Chart --}}
        <div class="bg-white/5 border border-white/10 rounded-xl p-6">
            <h3 class="text-xl font-bold mb-4">Revenue (Last 7 Days)</h3>
            <div class="space-y-2">
                @foreach($revenueChart as $day)
                <div class="flex items-center gap-3">
                    <p class="text-sm text-gray-400 w-16">{{ $day['date'] }}</p>
                    <div class="flex-1 bg-gray-700 rounded-full h-8 overflow-hidden">
                        <div class="bg-brand-accent h-full flex items-center px-3 text-black text-sm font-bold" 
                             style="width: {{ $day['revenue'] > 0 ? min(($day['revenue'] / max(array_column($revenueChart, 'revenue'))) * 100, 100) : 0 }}%">
                            ₹{{ number_format($day['revenue'], 0) }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Top Products --}}
        <div class="bg-white/5 border border-white/10 rounded-xl p-6">
            <h3 class="text-xl font-bold mb-4">Top Selling Products</h3>
            <div class="space-y-3">
                @foreach($topProducts as $product)
                <div class="flex items-center justify-between p-3 bg-black/30 rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium">#{{ $product->product_id }}</p>
                        <p class="text-sm text-gray-400">{{ $product->total_sold }} sold</p>
                    </div>
                    <p class="text-brand-accent font-bold">₹{{ number_format($product->revenue, 0) }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Orders --}}
        <div class="bg-white/5 border border-white/10 rounded-xl p-6">
            <h3 class="text-xl font-bold mb-4">Recent Orders</h3>
            <div class="space-y-2">
                @foreach($recentOrders as $order)
                <div class="flex items-center justify-between p-3 bg-black/30 rounded-lg hover:bg-black/50 transition">
                    <div>
                        <p class="font-medium">#{{ $order->id }}</p>
                        <p class="text-sm text-gray-400">{{ $order->user->name ?? 'Guest' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-brand-accent">₹{{ number_format($order->total, 0) }}</p>
                        <p class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Users --}}
        <div class="bg-white/5 border border-white/10 rounded-xl p-6">
            <h3 class="text-xl font-bold mb-4">Recent Registrations</h3>
            <div class="space-y-2">
                @foreach($recentUsers as $user)
                <div class="flex items-center gap-3 p-3 bg-black/30 rounded-lg hover:bg-black/50 transition">
                    <div class="w-10 h-10 bg-brand-accent/20 rounded-full flex items-center justify-center font-bold text-brand-accent">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <p class="font-medium">{{ $user->name }}</p>
                        <p class="text-sm text-gray-400">{{ $user->email }}</p>
                    </div>
                    <p class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
