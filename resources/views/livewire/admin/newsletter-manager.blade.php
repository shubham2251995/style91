<div>
    <h2 class="text-2xl font-bold mb-4">Newsletter Manager</h2>
    <button wire:click="openSendModal" class="bg-indigo-600 text-white px-4 py-2 rounded mb-4">Send Newsletter</button>

    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Subscribed</th>
                <th class="px-4 py-2 border">Joined Date</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subscribers as $subscriber)
                <tr>
                    <td class="px-4 py-2 border">{{ $subscriber->id }}</td>
                    <td class="px-4 py-2 border">{{ $subscriber->email }}</td>
                    <td class="px-4 py-2 border text-center">
                        @if($subscriber->is_subscribed)
                            <span class="text-green-600">✔</span>
                        @else
                            <span class="text-red-600">✖</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border">{{ $subscriber->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2 border">
                        <button wire:click="delete({{ $subscriber->id }})" class="text-red-600 hover:underline" onclick="return confirm('Delete this subscriber?')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $subscribers->links() }}
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-1/2">
                <h3 class="text-xl font-bold mb-4">Send Newsletter</h3>
                <form wire:submit.prevent="sendNewsletter">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Subject</label>
                        <input type="text" wire:model="subject" class="w-full border rounded p-2">
                        @error('subject') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Message</label>
                        <textarea wire:model="message" class="w-full border rounded p-2" rows="6"></textarea>
                        @error('message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 border rounded">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Send</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
