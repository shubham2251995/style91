<div class="p-4 bg-black min-h-screen text-white pb-20">
    <h2 class="text-xl font-black mb-6 text-brand-accent">MOBILE COMMANDER</h2>

    <div class="space-y-4">
        <!-- Quick Stats -->
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-gray-900 p-4 rounded-xl">
                <p class="text-xs text-gray-500">Sales</p>
                <p class="text-2xl font-bold">$12.4k</p>
            </div>
            <div class="bg-gray-900 p-4 rounded-xl">
                <p class="text-xs text-gray-500">Visitors</p>
                <p class="text-2xl font-bold">142</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <h3 class="font-bold text-sm text-gray-400 mt-6 mb-2">QUICK ACTIONS</h3>
        <button class="w-full bg-white/10 p-4 rounded-xl flex items-center justify-between hover:bg-white/20">
            <span class="font-bold">Toggle Maintenance Mode</span>
            <div class="w-10 h-6 bg-green-500 rounded-full relative"><div class="absolute right-1 top-1 w-4 h-4 bg-white rounded-full"></div></div>
        </button>
        <button class="w-full bg-white/10 p-4 rounded-xl flex items-center justify-between hover:bg-white/20">
            <span class="font-bold">Clear Cache</span>
            <span class="text-xs bg-gray-800 px-2 py-1 rounded">Run</span>
        </button>

        <!-- Recent Orders -->
        <h3 class="font-bold text-sm text-gray-400 mt-6 mb-2">LATEST ORDERS</h3>
        <div class="space-y-2">
            @foreach(range(1, 5) as $i)
                <div class="bg-gray-900 p-4 rounded-xl flex justify-between items-center">
                    <div>
                        <p class="font-bold text-sm">Order #{{ 1000 + $i }}</p>
                        <p class="text-xs text-gray-500">2 items • $145.00</p>
                    </div>
                    <span class="text-xs font-bold text-green-500">PAID</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
