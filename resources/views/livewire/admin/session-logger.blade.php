<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-white">Session Logger</h2>

    <div class="bg-white/5 rounded-xl overflow-hidden">
        <table class="w-full text-left text-sm text-gray-400">
            <thead class="bg-white/10 text-white uppercase font-bold">
                <tr>
                    <th class="p-4">User</th>
                    <th class="p-4">IP Address</th>
                    <th class="p-4">Device</th>
                    <th class="p-4">Started At</th>
                    <th class="p-4">Last Activity</th>
                    <th class="p-4">Events</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($sessions as $session)
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="p-4 font-bold text-white">
                        {{ $session->user ? $session->user->name : 'Guest' }}
                    </td>
                    <td class="p-4">{{ $session->ip_address }}</td>
                    <td class="p-4">{{ $session->user_agent }}</td>
                    <td class="p-4">{{ $session->started_at->diffForHumans() }}</td>
                    <td class="p-4">{{ $session->last_activity->diffForHumans() }}</td>
                    <td class="p-4">
                        <span class="bg-brand-accent/20 text-brand-accent px-2 py-1 rounded text-xs font-bold">
                            {{ $session->events->count() }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $sessions->links() }}
    </div>
</div>
