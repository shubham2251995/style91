<div class="p-6 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Order Manager</h2>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500/50 text-green-400 px-4 py-3 rounded-xl mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white/5 border border-white/10 rounded-xl p-4 mb-6 backdrop-blur-sm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Search orders, customers..." class="w-full bg-black/20 border-white/10 text-white placeholder-gray-500 rounded-lg px-3 py-2 text-sm focus:ring-brand-accent focus:border-brand-accent">
                </div>
                <div>
                    <select wire:model.live="filterStatus" class="w-full bg-black/20 border-white/10 text-white rounded-lg px-3 py-2 text-sm focus:ring-brand-accent focus:border-brand-accent">
                        <option value="" class="bg-gray-900">All Statuses</option>
                        @foreach($statusOptions as $status)
                            <option value="{{ $status }}" class="bg-gray-900">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <input type="date" wire:model.live="filterDateFrom" placeholder="From Date" class="w-full bg-black/20 border-white/10 text-white placeholder-gray-500 rounded-lg px-3 py-2 text-sm focus:ring-brand-accent focus:border-brand-accent">
                </div>
                <div>
                    <input type="date" wire:model.live="filterDateTo" placeholder="To Date" class="w-full bg-black/20 border-white/10 text-white placeholder-gray-500 rounded-lg px-3 py-2 text-sm focus:ring-brand-accent focus:border-brand-accent">
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden backdrop-blur-sm">
            <table class="min-w-full divide-y divide-white/5">
                <thead class="bg-white/5">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($orders as $order)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-white">#{{ $order->id }}</div>
                                @if($order->tracking_number)
                                    <div class="text-xs text-brand-accent">{{ $order->tracking_number }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-300">{{ $order->user->name ?? 'Guest' }}</div>
                                <div class="text-xs text-gray-500">{{ $order->user->email ?? '—' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $order->created_at->format('M d, Y') }}
                                <div class="text-xs text-gray-600">{{ $order->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-white">
                                ₹{{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-md 
                                    {{ $order->payment_status === 'paid' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : '' }}
                                    {{ $order->payment_status === 'pending' ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20' : '' }}
                                    {{ $order->payment_status === 'failed' ? 'bg-red-500/10 text-red-400 border border-red-500/20' : '' }}
                                    {{ $order->payment_status === 'cod' ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20' : '' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                                <div class="text-xs text-gray-500 mt-1">{{ strtoupper($order->payment_method) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-md 
                                    {{ $order->status === 'delivered' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : '' }}
                                    {{ $order->status === 'shipped' ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20' : '' }}
                                    {{ $order->status === 'processing' ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20' : '' }}
                                    {{ $order->status === 'pending' ? 'bg-gray-500/10 text-gray-400 border border-gray-500/20' : '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-red-500/10 text-red-400 border border-red-500/20' : '' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="viewOrder({{ $order->id }})" class="text-brand-accent hover:text-blue-400 transition-colors">View Details</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-16 h-16 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-lg font-medium text-gray-400">No orders found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-white/10">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

        <!-- Order Details Modal -->
        @if($isDetailsOpen && $selectedOrder)
        <div class="fixed z-50 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-black/80 transition-opacity backdrop-blur-sm"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-gray-900 border border-white/10 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="px-4 pt-5 pb-4 sm:p-6">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-bold text-white">Order #{{ $selectedOrder->id }}</h3>
                                <p class="text-sm text-gray-400">{{ $selectedOrder->created_at->format('F d, Y h:i A') }}</p>
                            </div>
                            <button wire:click="closeDetails" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <!-- Customer Info -->
                            <div class="bg-white/5 border border-white/10 p-4 rounded-xl">
                                <h4 class="font-bold text-gray-300 mb-2">Customer Information</h4>
                                <p class="text-sm text-gray-400"><span class="font-medium text-gray-500">Name:</span> {{ $selectedOrder->user->name ?? 'Guest' }}</p>
                                <p class="text-sm text-gray-400"><span class="font-medium text-gray-500">Email:</span> {{ $selectedOrder->user->email ?? '—' }}</p>
                                <p class="text-sm text-gray-400"><span class="font-medium text-gray-500">Phone:</span> {{ $selectedOrder->shipping_phone ?? '—' }}</p>
                            </div>

                            <!-- Shipping Info -->
                            <div class="bg-white/5 border border-white/10 p-4 rounded-xl">
                                <h4 class="font-bold text-gray-300 mb-2">Shipping Address</h4>
                                <p class="text-sm text-gray-400">{{ $selectedOrder->shipping_address ?? 'No address provided' }}</p>
                                
                                <div class="mt-4 border-t border-white/10 pt-2">
                                    <label class="block text-xs font-bold text-gray-500 mb-1">Tracking Number</label>
                                    <div class="flex gap-2">
                                        <input type="text" wire:model="trackingNumber" placeholder="Enter tracking #" class="flex-1 text-sm bg-black/20 border-white/10 rounded-md text-white focus:ring-brand-accent focus:border-brand-accent">
                                        <button wire:click="updateTracking({{ $selectedOrder->id }})" class="bg-brand-accent text-white px-3 py-1 rounded text-xs hover:bg-blue-600 transition-colors">Save</button>
                                    </div>
                                    @if($selectedOrder->tracking_number)
                                        <p class="text-xs text-green-400 mt-1">Current: {{ $selectedOrder->tracking_number }}</p>
                                    @endif
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- Payment & Transaction Info -->
                        <div class="mb-6 bg-white/5 border border-white/10 rounded-xl p-4">
                            <h4 class="font-bold text-gray-300 mb-2">Payment Details</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">Method</p>
                                    <p class="text-sm font-medium text-white">{{ strtoupper($selectedOrder->payment_method) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Status</p>
                                    <p class="text-sm font-medium {{ $selectedOrder->payment_status === 'paid' ? 'text-green-400' : 'text-yellow-400' }}">
                                        {{ ucfirst($selectedOrder->payment_status) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Transaction ID</p>
                                    <p class="text-sm font-mono text-gray-300">{{ $selectedOrder->payment_id ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Date</p>
                                    <p class="text-sm text-gray-300">{{ $selectedOrder->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="mb-6 bg-white/5 border border-white/10 rounded-xl overflow-hidden">
                            <h4 class="font-bold text-gray-300 p-4 border-b border-white/10">Order Items</h4>
                            <table class="min-w-full divide-y divide-white/10">
                                <thead class="bg-white/5">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-400">Product</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-400">Qty</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-400">Price</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-400">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/10">
                                    @foreach($selectedOrder->items as $item)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-300">{{ $item->product->name ?? 'Product' }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-300">{{ $item->quantity }}</td>
                                            <td class="px-4 py-3 text-sm text-right text-gray-300">₹{{ number_format($item->price, 2) }}</td>
                                            <td class="px-4 py-3 text-sm text-right font-bold text-white">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-white/5 border-t border-white/10">
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-right font-bold text-gray-300">Total:</td>
                                        <td class="px-4 py-3 text-right font-bold text-lg text-brand-accent">₹{{ number_format($selectedOrder->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Status Update -->
                        <div class="mb-6">
                            <h4 class="font-bold text-gray-300 mb-3">Update Status</h4>
                            <div class="flex gap-2 flex-wrap">
                                @foreach($statusOptions as $status)
                                    <button 
                                        wire:click="updateStatus({{ $selectedOrder->id }}, '{{ $status }}')"
                                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                                            {{ $selectedOrder->status === $status ? 'bg-brand-accent text-white shadow-lg shadow-blue-900/20' : 'bg-white/5 text-gray-400 hover:bg-white/10 hover:text-white border border-white/10' }}">
                                        {{ ucfirst($status) }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="bg-black/40 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-white/10">
                        <button wire:click="printInvoice({{ $selectedOrder->id }})" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-brand-accent text-white hover:bg-blue-600 sm:ml-3 sm:w-auto sm:text-sm transition-colors font-bold">
                            Print Invoice
                        </button>
                        <button wire:click="closeDetails" class="mt-3 w-full inline-flex justify-center rounded-lg border border-white/10 shadow-sm px-4 py-2 bg-white/5 text-gray-300 hover:bg-white/10 sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
