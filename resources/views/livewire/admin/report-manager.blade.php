<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Report Manager</h2>

        <div class="bg-white rounded-lg shadow p-6">
            <form wire:submit.prevent="generateReport">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Report Type</label>
                        <select wire:model="reportType" class="w-full border rounded p-2">
                            <option value="sales">Sales Report</option>
                            <option value="products">Product Performance</option>
                            <option value="customers">Customer Report</option>
                        </select>
                    </div>
                    <div></div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Start Date</label>
                        <input type="date" wire:model="startDate" class="w-full border rounded p-2">
                        @error('startDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">End Date</label>
                        <input type="date" wire:model="endDate" class="w-full border rounded p-2">
                        @error('endDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                    Generate & Download CSV
                </button>
            </form>

            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded">
                <h3 class="font-bold text-blue-900 mb-2">Report Types:</h3>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li><strong>Sales Report:</strong> All orders with customer details</li>
                    <li><strong>Product Performance:</strong> Units sold and revenue per product</li>
                    <li><strong>Customer Report:</strong> Customer lifetime value and order count</li>
                </ul>
            </div>
        </div>
    </div>
</div>
