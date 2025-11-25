<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-brand-dark">Fraud Detection</h1>
        <div class="flex items-center gap-2">
            <select wire:model.live="filterLevel" class="border border-gray-300 rounded-lg px-4 py-2 text-sm">
                <option value="">All Risk Levels</option>
                <option value="low">Low Risk</option>
                <option value="medium">Medium Risk</option>
                <option value="high">High Risk</option>
            </select>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase font-bold mb-1">Total Checks</p>
            <p class="text-2xl font-black text-brand-dark">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <p class="text-xs text-red-600 uppercase font-bold mb-1">High Risk</p>
            <p class="text-2xl font-black text-red-600">{{ $stats['high_risk'] }}</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <p class="text-xs text-yellow-600 uppercase font-bold mb-1">Medium Risk</p>
            <p class="text-2xl font-black text-yellow-600">{{ $stats['medium_risk'] }}</p>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
            <p class="text-xs text-gray-600 uppercase font-bold mb-1">Blocked</p>
            <p class="text-2xl font-black text-gray-800">{{ $stats['blocked'] }}</p>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-xs text-blue-600 uppercase font-bold mb-1">Today</p>
            <p class="text-2xl font-black text-blue-600">{{ $stats['today'] }}</p>
        </div>
    </div>

    <!-- Fraud Logs Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Date/Time</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Order/User</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Risk Level</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Score</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Flags</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div>
                            @if($log->order_number)
                                <span class="font-bold text-brand-dark">Order #{{ $log->order_number }}</span>
                            @else
                                <span class="text-gray-400">No Order</span>
                            @endif
                        </div>
                        @if($log->user_name)
                            <div class="text-xs text-gray-500">{{ $log->user_name }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($log->risk_level === 'high')
                            <span class="px-2 py-1 bg-red-100 text-red-600 text-xs font-bold rounded">HIGH</span>
                        @elseif($log->risk_level === 'medium')
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 text-xs font-bold rounded">MEDIUM</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-600 text-xs font-bold rounded">LOW</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-900">
                        {{ $log->risk_score }}
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-600">
                        @php
                            $flags = json_decode($log->flags, true) ?? [];
                        @endphp
                        @if(count($flags) > 0)
                            <div class="space-y-1">
                                @foreach(array_slice($flags, 0, 2) as $flag)
                                    <div class="flex items-center gap-1">
                                        <span class="text-red-500">⚠</span>
                                        <span>{{ $flag['type'] }}</span>
                                    </div>
                                @endforeach
                                @if(count($flags) > 2)
                                    <div class="text-gray-400">+{{ count($flags) - 2 }} more</div>
                                @endif
                            </div>
                        @else
                            <span class="text-gray-400">No flags</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($log->action === 'block')
                            <span class="px-2 py-1 bg-red-600 text-white text-xs font-bold rounded">BLOCKED</span>
                        @elseif($log->action === 'review')
                            <span class="px-2 py-1 bg-yellow-500 text-white text-xs font-bold rounded">REVIEW</span>
                        @else
                            <span class="px-2 py-1 bg-green-600 text-white text-xs font-bold rounded">APPROVED</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        No fraud checks logged yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
