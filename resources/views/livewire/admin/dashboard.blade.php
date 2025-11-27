<div class="p-6">
    <h2 class="text-3xl font-bold mb-8 text-gray-800">Dashboard Overview</h2>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Revenue</p>
                    <p class="text-3xl font-bold">₹{{ number_format($totalRevenue, 2) }}</p>
                    <p class="text-xs text-blue-100 mt-1">Today: ₹{{ number_format($todayRevenue, 0) }}</p>
                </div>
                <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium mb-1">Pending Orders</p>
                    <p class="text-3xl font-bold">{{ $pendingOrders }}</p>
                    <p class="text-xs text-yellow-100 mt-1">Requires Action</p>
                </div>
                <svg class="w-12 h-12 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium mb-1">Low Stock</p>
                    <p class="text-3xl font-bold">{{ $lowStockProducts->count() }}</p>
                    <p class="text-xs text-red-100 mt-1">Out of Stock: {{ $outOfStock }}</p>
                </div>
                <svg class="w-12 h-12 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-1">Total Customers</p>
                    <p class="text-3xl font-bold">{{ $totalCustomers }}</p>
                    <p class="text-xs text-green-100 mt-1">New Today: {{ $newCustomersToday }}</p>
                </div>
                <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-lg text-gray-800">Recent Orders</h3>
                <a href="{{ route('admin.order-manager') }}" class="text-indigo-600 text-sm hover:text-indigo-800">View All →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentOrders as $order)
                    <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:bg-gray-50">
                        <div>
                            <p class="font-bold text-gray-800">#{{ $order->id }}</p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-mono font-bold">₹{{ number_format($order->total_amount, 0) }}</p>
                            <span class="text-xs px-2 py-1 rounded-full {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No orders yet</p>
                @endforelse
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-lg text-gray-800">Low Stock Alert</h3>
                <a href="{{ route('admin.inventory-manager') }}" class="text-indigo-600 text-sm hover:text-indigo-800">Manage →</a>
            </div>
            <div class="space-y-2">
                @forelse($lowStockProducts as $product)
                    <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                        <div class="flex-1">
                            <p class="font-medium text-gray-800 text-sm">{{ $product->name }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-bold {{ $product->stock_quantity <= 3 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $product->stock_quantity }} left
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Stock levels good!</p>
                @endforelse
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold text-lg text-gray-800 mb-4">Top Selling Products</h3>
            <div class="space-y-3">
                @forelse($topProducts as $product)
                    <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">₹{{ number_format($product->price, 0) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-indigo-600">{{ $product->order_items_count ?? 0 }}</p>
                            <p class="text-xs text-gray-500">orders</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No sales data yet</p>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold text-lg text-gray-800 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('admin.product-manager') }}" class="p-4 border-2 border-gray-200 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition text-center">
                    <p class="font-bold text-gray-800 text-sm">Add Product</p>
                </a>
                <a href="{{ route('admin.order-manager') }}" class="p-4 border-2 border-gray-200 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition text-center">
                    <p class="font-bold text-gray-800 text-sm">View Orders</p>
                </a>
                <a href="{{ route('admin.coupon-manager') }}" class="p-4 border-2 border-gray-200 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition text-center">
                    <p class="font-bold text-gray-800 text-sm">Create Coupon</p>
                </a>
                <a href="{{ route('admin.stock-adjustments') }}" class="p-4 border-2 border-gray-200 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition text-center">
                    <p class="font-bold text-gray-800 text-sm">Adjust Stock</p>
                </a>
            </div>
        </div>
    </div>
</div>
