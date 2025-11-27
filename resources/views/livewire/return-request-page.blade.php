<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h1 class="text-2xl font-bold mb-6">Request Return</h1>

            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="font-bold mb-2">Order #{{ $order->id }}</h3>
                <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('M d, Y') }}</p>
            </div>

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="submitReturn">
                <!-- Product Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Product (Optional)</label>
                    <p class="text-xs text-gray-500 mb-3">Leave unselected to return the entire order</p>
                    
                    <div class="space-y-2">
                        @foreach($order->items as $item)
                            <div wire:click="$set('selectedProductId', {{ $item->product_id }})" 
                                 class="p-3 border rounded-lg cursor-pointer {{ $selectedProductId == $item->product_id ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200 hover:border-gray-300' }}">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item->product->image_url }}" class="w-16 h-16 object-cover rounded" alt="{{ $item->product->name }}">
                                    <div>
                                        <div class="font-medium">{{ $item->product->name }}</div>
                                        <div class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Reason -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Return *</label>
                    <select wire:model="reason" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <option value="">Select a reason</option>
                        <option value="defective">Defective/Damaged Product</option>
                        <option value="wrong_item">Wrong Item Received</option>
                        <option value="not_as_described">Not as Described</option>
                        <option value="size_issue">Size/Fit Issue</option>
                        <option value="changed_mind">Changed Mind</option>
                        <option value="other">Other</option>
                    </select>
                    @error('reason') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Details -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Details *</label>
                    <textarea wire:model="details" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2" 
                              placeholder="Please provide details about why you're returning this item..."></textarea>
                    @error('details') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-500 mt-1">Minimum 10 characters</p>
                </div>

                <!-- Return Policy Notice -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h4 class="font-bold text-blue-900 mb-2">Return Policy</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Returns accepted within 30 days of delivery</li>
                        <li>• Items must be unused and in original packaging</li>
                        <li>• Refund will be processed within 5-7 business days after approval</li>
                        <li>• Return shipping may be charged for certain reasons</li>
                    </ul>
                </div>

                <!-- Actions -->
                <div class="flex gap-3">
                    <a href="{{ route('account.order', $orderId) }}" class="flex-1 px-6 py-3 border-2 border-gray-300 rounded-lg text-center font-bold hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700">
                        Submit Return Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
