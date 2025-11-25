<div>
    <h2 class="text-2xl font-bold mb-4">Return Requests</h2>

    <div class="mb-4">
        <select wire:model.live="statusFilter" class="border rounded p-2">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
            <option value="refunded">Refunded</option>
        </select>
    </div>

    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Order</th>
                <th class="px-4 py-2 border">User</th>
                <th class="px-4 py-2 border">Product</th>
                <th class="px-4 py-2 border">Reason</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Date</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($returns as $return)
                <tr>
                    <td class="px-4 py-2 border">{{ $return->id }}</td>
                    <td class="px-4 py-2 border">#{{ $return->order_id }}</td>
                    <td class="px-4 py-2 border">{{ $return->user->name ?? 'Unknown' }}</td>
                    <td class="px-4 py-2 border">{{ $return->product->name ?? 'General' }}</td>
                    <td class="px-4 py-2 border">
                        {{ $return->reason }}
                        <div class="text-xs text-gray-500">{{ $return->details }}</div>
                    </td>
                    <td class="px-4 py-2 border">
                        <span class="px-2 py-1 rounded text-sm font-bold
                            @if($return->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($return->status == 'approved') bg-blue-100 text-blue-800
                            @elseif($return->status == 'rejected') bg-red-100 text-red-800
                            @elseif($return->status == 'refunded') bg-green-100 text-green-800
                            @endif">
                            {{ ucfirst($return->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border">{{ $return->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2 border">
                        @if($return->status == 'pending')
                            <button wire:click="approve({{ $return->id }})" class="bg-blue-500 text-white px-2 py-1 rounded mr-1 text-xs">Approve</button>
                            <button wire:click="reject({{ $return->id }})" class="bg-red-500 text-white px-2 py-1 rounded text-xs">Reject</button>
                        @elseif($return->status == 'approved')
                            <button wire:click="refund({{ $return->id }})" class="bg-green-500 text-white px-2 py-1 rounded text-xs">Mark Refunded</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="mt-4">
        {{ $returns->links() }}
    </div>
</div>
