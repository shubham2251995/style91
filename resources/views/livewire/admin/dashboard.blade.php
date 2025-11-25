<div>
    <h2 class="text-3xl font-bold mb-8">Mission Control</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Stat Card 1 -->
        <div class="bg-white/5 border border-white/10 p-6 rounded-2xl">
            <p class="text-gray-400 text-sm font-mono mb-2">TOTAL REVENUE</p>
            <p class="text-3xl font-bold">${{ number_format(\App\Models\Order::sum('total'), 2) }}</p>
        </div>
        <!-- Stat Card 2 -->
        <div class="bg-white/5 border border-white/10 p-6 rounded-2xl">
            <p class="text-gray-400 text-sm font-mono mb-2">ACTIVE ORDERS</p>
            <p class="text-3xl font-bold">{{ \App\Models\Order::where('status', 'pending')->count() }}</p>
        </div>
        <!-- Stat Card 3 -->
        <div class="bg-white/5 border border-white/10 p-6 rounded-2xl">
            <p class="text-gray-400 text-sm font-mono mb-2">TOTAL USERS</p>
            <p class="text-3xl font-bold">{{ \App\Models\User::count() }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Activity -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
            <h3 class="font-bold text-xl mb-4">Recent Orders</h3>
            <div class="space-y-4">
                @foreach(\App\Models\Order::latest()->take(5)->get() as $order)
                <div class="flex justify-between items-center border-b border-white/5 pb-2 last:border-0">
                    <div>
                        <p class="font-bold">Order #{{ $order->id }}</p>
                        <p class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-mono">${{ $order->total }}</p>
                        <span class="text-xs bg-blue-500/20 text-blue-400 px-2 py-1 rounded">{{ $order->status }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- System Status -->
        <livewire:admin.system-health />
    </div>
</div>
