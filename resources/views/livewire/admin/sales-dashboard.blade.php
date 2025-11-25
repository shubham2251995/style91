<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Sales Analytics</h2>
            <select wire:model.live="dateRange" class="border rounded px-4 py-2">
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="year">This Year</option>
            </select>
        </div>

        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm text-gray-500 mb-1">Total Revenue</div>
                <div class="text-3xl font-bold text-green-600">₹{{ number_format($totalRevenue, 2) }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm text-gray-500 mb-1">Total Orders</div>
                <div class="text-3xl font-bold text-blue-600">{{ $totalOrders }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm text-gray-500 mb-1">Avg Order Value</div>
                <div class="text-3xl font-bold text-purple-600">₹{{ number_format($avgOrderValue, 2) }}</div>
            </div>
        </div>

        <!-- Sales Chart -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h3 class="text-lg font-bold mb-4">Sales Trend</h3>
            <canvas id="salesChart" height="80"></canvas>
        </div>

        <!-- Top Products -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Top Selling Products</h3>
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Product</th>
                        <th class="text-right py-2">Units Sold</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProducts as $item)
                        <tr class="border-b">
                            <td class="py-2">{{ $item->product->name ?? 'Unknown' }}</td>
                            <td class="text-right py-2 font-bold">{{ $item->total_sold }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('livewire:navigated', function() {
            renderChart();
        });

        document.addEventListener('DOMContentLoaded', function() {
            renderChart();
        });

        function renderChart() {
            const ctx = document.getElementById('salesChart');
            if (!ctx) return;

            const data = @json($dailySales);
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(d => d.date),
                    datasets: [{
                        label: 'Revenue',
                        data: data.map(d => d.revenue),
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    </script>
    @endpush
</div>
