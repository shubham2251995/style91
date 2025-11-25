<div>
    <h2 class="text-2xl font-bold mb-4">Loyalty Points Manager</h2>
    <button wire:click="create" class="bg-indigo-600 text-white px-4 py-2 rounded mb-4">Adjust Points</button>

    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">User</th>
                <th class="px-4 py-2 border">Points</th>
                <th class="px-4 py-2 border">Type</th>
                <th class="px-4 py-2 border">Description</th>
                <th class="px-4 py-2 border">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td class="px-4 py-2 border">{{ $transaction->id }}</td>
                    <td class="px-4 py-2 border">{{ $transaction->user->name ?? 'Unknown' }}</td>
                    <td class="px-4 py-2 border font-bold {{ $transaction->points > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $transaction->points > 0 ? '+' : '' }}{{ $transaction->points }}
                    </td>
                    <td class="px-4 py-2 border">{{ ucfirst($transaction->type) }}</td>
                    <td class="px-4 py-2 border">{{ $transaction->description }}</td>
                    <td class="px-4 py-2 border">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-96">
                <h3 class="text-xl font-bold mb-4">Adjust Points</h3>
                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">User</label>
                        <select wire:model="userId" class="w-full border rounded p-2">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        @error('userId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Points (+/-)</label>
                        <input type="number" wire:model="points" class="w-full border rounded p-2" placeholder="e.g. 100 or -50">
                        @error('points') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Description</label>
                        <input type="text" wire:model="description" class="w-full border rounded p-2">
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 border rounded">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
