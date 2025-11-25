<div class="min-h-screen bg-brand-gray py-12">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow-sm p-8">
            <h1 class="text-3xl font-bold text-brand-dark mb-2">Track Your Order</h1>
            <p class="text-gray-600 mb-8">Enter your order details to track your shipment</p>

            @if(!$order)
                <form wire:submit.prevent="track" class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Order Number</label>
                        <input 
                            wire:model="orderId" 
                            type="text" 
                            placeholder="e.g., 12345"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-accent"
                        >
                        @error('orderId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                        <input 
                            wire:model="email" 
                            type="email" 
                            placeholder="your@email.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-accent"
                        >
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    @if($error)
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            {{ $error }}
                        </div>
                    @endif

                    <button 
                        type="submit"
                        wire:loading.attr="disabled"
                        class="w-full bg-brand-accent text-brand-dark font-bold py-4 rounded-lg hover:bg-yellow-400 transition disabled:opacity-50"
                    >
                        <span wire:loading.remove>Track Order</span>
                        <span wire:loading>Searching...</span>
                    </button>
                </form>
            @else
                <!-- Order Details -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between pb-6 border-b border-gray-200">
                        <div>
                            <h2 class="text-xl font-bold text-brand-dark">Order #{{ $order->id }}</h2>
                            <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <span class="px-4 py-2 rounded-full text-sm font-bold
                            @if($order->status === 'completed') bg-green-100 text-green-700
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700
                            @endif
                        ">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <!-- Order Status Timeline -->
                    <div class="py-6">
                        <h3 class="font-bold text-lg mb-4">Order Status</h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white">✓</div>
                                <div>
                                    <p class="font-bold text-sm">Order Placed</p>
                                    <p class="text-xs text-gray-600">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['processing', 'shipped', 'completed']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center text-white">
                                    {{ in_array($order->status, ['processing', 'shipped', 'completed']) ? '✓' : '2' }}
                                </div>
                                <div>
                                    <p class="font-bold text-sm">Processing</p>
                                    <p class="text-xs text-gray-600">{{ in_array($order->status, ['processing', 'shipped', 'completed']) ? 'In progress' : 'Pending' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['shipped', 'completed']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center text-white">
                                    {{ in_array($order->status, ['shipped', 'completed']) ? '✓' : '3' }}
                                </div>
                                <div>
                                    <p class="font-bold text-sm">Shipped</p>
                                    <p class="text-xs text-gray-600">{{ $order->status === 'shipped' || $order->status === 'completed' ? 'On the way' : 'Awaiting shipment' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full {{ $order->status === 'completed' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center text-white">
                                    {{ $order->status === 'completed' ? '✓' : '4' }}
                                </div>
                                <div>
                                    <p class="font-bold text-sm">Delivered</p>
                                    <p class="text-xs text-gray-600">{{ $order->status === 'completed' ? 'Delivered' : 'Pending delivery' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="font-bold text-lg mb-4">Order Items</h3>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex gap-4">
                                    <img src="{{ $item->product->image_url ?? '/images/placeholder.png' }}" class="w-20 h-20 object-cover rounded-lg bg-gray-100">
                                    <div class="flex-1">
                                        <h4 class="font-bold text-sm">{{ $item->product_name }}</h4>
                                        <p class="text-xs text-gray-600">Quantity: {{ $item->quantity }}</p>
                                        <p class="text-sm font-bold text-brand-dark mt-1">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="pt-6 border-t border-gray-200">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-bold">${{ number_format($order->total, 2) }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                        <div class="flex justify-between mb-2 text-green-600">
                            <span>Discount</span>
                            <span class="font-bold">-${{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-lg font-bold pt-4 border-t border-gray-200">
                            <span>Total</span>
                            <span>${{ number_format($order->total - ($order->discount_amount ?? 0), 2) }}</span>
                        </div>
                    </div>

                    <button 
                        wire:click="$set('order', null)"
                        class="w-full mt-6 bg-gray-100 text-gray-700 font-bold py-3 rounded-lg hover:bg-gray-200 transition"
                    >
                        Track Another Order
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
