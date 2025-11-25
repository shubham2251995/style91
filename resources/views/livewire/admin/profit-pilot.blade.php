<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-white">Profit Pilot</h2>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white/5 p-6 rounded-xl border border-white/10">
            <h3 class="text-gray-400 text-sm font-bold uppercase mb-2">Total Revenue</h3>
            <p class="text-3xl font-mono text-green-400">${{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="bg-white/5 p-6 rounded-xl border border-white/10">
            <h3 class="text-gray-400 text-sm font-bold uppercase mb-2">Total Orders</h3>
            <p class="text-3xl font-mono text-white">{{ $totalOrders }}</p>
        </div>
        <div class="bg-white/5 p-6 rounded-xl border border-white/10">
            <h3 class="text-gray-400 text-sm font-bold uppercase mb-2">Avg. Order Value</h3>
            <p class="text-3xl font-mono text-blue-400">${{ number_format($averageOrderValue, 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top Products -->
        <div class="bg-white/5 rounded-xl overflow-hidden border border-white/10">
            <div class="p-4 border-b border-white/10">
                <h3 class="font-bold text-white">Top Performers</h3>
            </div>
            <table class="w-full text-left text-sm text-gray-400">
                <thead class="bg-white/5 text-xs uppercase">
                    <tr>
                        <th class="p-3">Product</th>
                        <th class="p-3 text-right">Sold</th>
                        <th class="p-3 text-right">Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($topProducts as $product)
                    <tr>
                        <td class="p-3 text-white">{{ $product->name }}</td>
                        <td class="p-3 text-right">{{ $product->total_sold }}</td>
                        <td class="p-3 text-right font-mono text-green-400">${{ number_format($product->revenue, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Recent Sales -->
        <div class="bg-white/5 rounded-xl overflow-hidden border border-white/10">
            <div class="p-4 border-b border-white/10">
                <h3 class="font-bold text-white">Recent Transactions</h3>
            </div>
            <div class="divide-y divide-white/5">
                @foreach($recentSales as $sale)
                <div class="p-3 flex justify-between items-center">
                    <div>
                        <p class="text-white font-bold">Order #{{ $sale->id }}</p>
                        <p class="text-xs text-gray-500">{{ $sale->created_at->diffForHumans() }} by {{ $sale->user ? $sale->user->name : 'Guest' }}</p>
                    </div>
                    <span class="font-mono text-green-400 font-bold">${{ number_format($sale->total_amount, 2) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
