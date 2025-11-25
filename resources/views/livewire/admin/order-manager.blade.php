<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Order Manager</h2>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Search orders, customers..." class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <select wire:model.live="filterStatus" class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="">All Statuses</option>
                        @foreach($statusOptions as $status)
                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <input type="date" wire:model.live="filterDateFrom" placeholder="From Date" class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <input type="date" wire:model.live="filterDateTo" placeholder="To Date" class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">#{{ $order->id }}</div>
                                @if($order->tracking_number)
                                    <div class="text-xs text-gray-500">{{ $order->tracking_number }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'Guest' }}</div>
                                <div class="text-xs text-gray-500">{{ $order->user->email ?? '—' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('M d, Y') }}
                                <div class="text-xs text-gray-400">{{ $order->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                ₹{{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $order->status === 'shipped' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $order->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $order->status === 'pending' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="viewOrder({{ $order->id }})" class="text-indigo-600 hover:text-indigo-900">View Details</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-lg font-medium">No orders found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

        <!-- Order Details Modal -->
        @if($isDetailsOpen && $selectedOrder)
        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">Order #{{ $selectedOrder->id }}</h3>
                                <p class="text-sm text-gray-500">{{ $selectedOrder->created_at->format('F d, Y h:i A') }}</p>
                            </div>
                            <button wire:click="closeDetails" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <!-- Customer Info -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-bold text-gray-900 mb-2">Customer Information</h4>
                                <p class="text-sm"><span class="font-medium">Name:</span> {{ $selectedOrder->user->name ?? 'Guest' }}</p>
                                <p class="text-sm"><span class="font-medium">Email:</span> {{ $selectedOrder->user->email ?? '—' }}</p>
                                <p class="text-sm"><span class="font-medium">Phone:</span> {{ $selectedOrder->shipping_phone ?? '—' }}</p>
                            </div>

                            <!-- Shipping Info -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-bold text-gray-900 mb-2">Shipping Address</h4>
                                <p class="text-sm">{{ $selectedOrder->shipping_address ?? 'No address provided' }}</p>
                                
                                <div class="mt-4 border-t pt-2">
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Tracking Number</label>
                                    <div class="flex gap-2">
                                        <input type="text" wire:model="trackingNumber" placeholder="Enter tracking #" class="flex-1 text-sm border-gray-300 rounded-md">
                                        <button wire:click="updateTracking({{ $selectedOrder->id }})" class="bg-indigo-600 text-white px-3 py-1 rounded text-xs hover:bg-indigo-700">Save</button>
                                    </div>
                                    @if($selectedOrder->tracking_number)
                                        <p class="text-xs text-green-600 mt-1">Current: {{ $selectedOrder->tracking_number }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="mb-6">
                            <h4 class="font-bold text-gray-900 mb-3">Order Items</h4>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Product</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Qty</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Price</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($selectedOrder->items as $item)
                                        <tr>
                                            <td class="px-4 py-3 text-sm">{{ $item->product->name ?? 'Product' }}</td>
                                            <td class="px-4 py-3 text-sm">{{ $item->quantity }}</td>
                                            <td class="px-4 py-3 text-sm text-right">₹{{ number_format($item->price, 2) }}</td>
                                            <td class="px-4 py-3 text-sm text-right font-bold">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-right font-bold">Total:</td>
                                        <td class="px-4 py-3 text-right font-bold text-lg">₹{{ number_format($selectedOrder->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Status Update -->
                        <div class="mb-6">
                            <h4 class="font-bold text-gray-900 mb-3">Update Status</h4>
                            <div class="flex gap-2">
                                @foreach($statusOptions as $status)
                                    <button 
                                        wire:click="updateStatus({{ $selectedOrder->id }}, '{{ $status }}')"
                                        class="px-4 py-2 rounded-lg text-sm font-medium
                                            {{ $selectedOrder->status === $status ? 'bg-brand-dark text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                        {{ ucfirst($status) }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="printInvoice({{ $selectedOrder->id }})" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand-dark text-white hover:bg-brand-accent hover:text-brand-dark sm:ml-3 sm:w-auto sm:text-sm">
                            Print Invoice
                        </button>
                        <button wire:click="closeDetails" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
