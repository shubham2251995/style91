<div>
    <h2 class="text-2xl font-bold mb-4">Abandoned Carts</h2>
    <p class="text-gray-600 mb-6">Carts inactive for more than 1 hour.</p>

    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">Customer</th>
                <th class="px-4 py-2 border">Items</th>
                <th class="px-4 py-2 border">Total Value</th>
                <th class="px-4 py-2 border">Last Active</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($carts as $cart)
                <tr>
                    <td class="px-4 py-2 border">
                        <div class="font-bold">{{ $cart->customer_name }}</div>
                        <div class="text-xs text-gray-500">{{ $cart->customer_email }}</div>
                        @if(!$cart->user_id)
                            <div class="text-xs text-gray-400">Session: {{ Str::limit($cart->session_id, 8) }}</div>
                        @endif
                    </td>
                    <td class="px-4 py-2 border">
                        {{ $cart->items_count }} items
                        <div class="text-xs text-gray-500 mt-1">
                            @foreach($cart->items->take(3) as $item)
                                <div>{{ $item->product->name }} (x{{ $item->quantity }})</div>
                            @endforeach
                            @if($cart->items->count() > 3)
                                <div>...</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-2 border font-bold">₹{{ number_format($cart->total, 2) }}</td>
                    <td class="px-4 py-2 border text-sm text-gray-600">
                        {{ $cart->last_update->diffForHumans() }}
                    </td>
                    <td class="px-4 py-2 border">
                        <!-- Future: Email Reminder Button -->
                        <button class="bg-gray-300 text-gray-600 px-3 py-1 rounded text-sm cursor-not-allowed" disabled>Send Reminder</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">No abandoned carts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $carts->links() }}
    </div>
</div>
