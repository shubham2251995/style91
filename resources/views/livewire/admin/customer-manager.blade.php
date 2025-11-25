<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Customer Manager</h2>
        </div>

        <!-- Search -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Search customers by name or email..." class="w-full border-gray-300 rounded-lg px-3 py-2">
        </div>

        <!-- Customers Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orders</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $customer->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $customer->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $customer->orders_count }} orders
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $customer->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="viewCustomer({{ $customer->id }})" class="text-indigo-600 hover:text-indigo-900">View Details</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <p class="text-lg font-medium">No customers found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($customers->hasPages())
                <div class="px-6 py-4 border-t">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>

        <!-- Customer Details Modal -->
        @if($isDetailsOpen && $selectedCustomer)
        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $selectedCustomer->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $selectedCustomer->email }}</p>
                            </div>
                            <button wire:click="closeDetails" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Total Orders</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $selectedCustomer->orders->count() }}</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Lifetime Value</div>
                                <div class="text-2xl font-bold text-green-600">₹{{ number_format($selectedCustomer->orders->sum('total_amount'), 2) }}</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Member Since</div>
                                <div class="text-lg font-bold text-gray-900">{{ $selectedCustomer->created_at->format('M Y') }}</div>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-bold text-gray-900 mb-3">Recent Orders</h4>
                            <div class="space-y-2">
                                @forelse($selectedCustomer->orders->take(5) as $order)
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <div class="text-sm font-bold">Order #{{ $order->id }}</div>
                                            <div class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y') }}</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm font-bold">₹{{ number_format($order->total_amount, 2) }}</div>
                                            <div class="text-xs text-gray-500">{{ ucfirst($order->status) }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">No orders yet</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="closeDetails" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
