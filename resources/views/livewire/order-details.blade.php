<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="mb-6">
        <a href="{{ route('account') }}" class="text-indigo-600 hover:underline">&larr; Back to Dashboard</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Order #{{ $order->id }}</h1>
            <span class="px-3 py-1 rounded-full text-sm font-semibold
                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Shipping Address</h3>
                <div class="text-gray-600">
                    @if(is_array($order->shipping_address))
                        {{ $order->shipping_address['full_name'] ?? '' }}<br>
                        {{ $order->shipping_address['address_line_1'] ?? '' }}<br>
                        {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }} {{ $order->shipping_address['postcode'] ?? '' }}<br>
                        {{ $order->shipping_address['country'] ?? '' }}
                    @else
                        {{ json_decode($order->shipping_address)->full_name ?? '' }}<br>
                        {{ json_decode($order->shipping_address)->address_line_1 ?? '' }}<br>
                        {{ json_decode($order->shipping_address)->city ?? '' }}, {{ json_decode($order->shipping_address)->state ?? '' }} {{ json_decode($order->shipping_address)->postcode ?? '' }}<br>
                        {{ json_decode($order->shipping_address)->country ?? '' }}
                    @endif
                </div>
            </div>
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Order Summary</h3>
                <div class="flex justify-between mb-1">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between mb-1">
                    <span>Shipping</span>
                    <span>${{ number_format($order->shipping_cost, 2) }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg mt-2 pt-2 border-t">
                    <span>Total</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <h3 class="font-semibold text-gray-700 mb-4">Items</h3>
        <div class="space-y-4">
            @foreach($order->items as $item)
                <div class="flex items-center justify-between border-b pb-4 last:border-0">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/80' }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                        <div>
                            <h4 class="font-medium">{{ $item->product->name }}</h4>
                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                            <p class="text-sm text-gray-500">${{ number_format($item->price, 2) }}</p>
                        </div>
                    </div>
                    <div>
                        @php
                            $existingReturn = $order->returnRequests->where('product_id', $item->product_id)->first();
                        @endphp
                        
                        @if($existingReturn)
                            <span class="text-sm text-orange-600 font-medium">Return {{ ucfirst($existingReturn->status) }}</span>
                        @elseif($order->status === 'delivered' || $order->status === 'completed')
                            <button wire:click="openReturnModal({{ $item->product_id }})" class="text-sm text-indigo-600 hover:underline">Request Return</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($order->status === 'delivered' || $order->status === 'completed')
             <div class="mt-6 pt-6 border-t">
                <button wire:click="openReturnModal" class="text-sm text-gray-600 hover:text-gray-900">Return Entire Order</button>
             </div>
        @endif
    </div>

    <!-- Return Modal -->
    @if($showReturnModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-xl font-bold mb-4">Request Return</h3>
                <form wire:submit.prevent="submitReturn">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                        <select wire:model="returnReason" class="w-full border rounded p-2">
                            <option value="">Select a reason</option>
                            <option value="wrong_size">Wrong Size</option>
                            <option value="damaged">Damaged/Defective</option>
                            <option value="not_as_described">Not as Described</option>
                            <option value="changed_mind">Changed Mind</option>
                            <option value="other">Other</option>
                        </select>
                        @error('returnReason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Details</label>
                        <textarea wire:model="returnDetails" class="w-full border rounded p-2" rows="3"></textarea>
                        @error('returnDetails') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" wire:click="$set('showReturnModal', false)" class="px-4 py-2 border rounded hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
