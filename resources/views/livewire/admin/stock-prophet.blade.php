<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-white">Stock Prophet <span class="text-sm font-normal text-gray-500 ml-2">AI Inventory Forecasting</span></h2>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-400">
            <thead class="bg-white/5 uppercase font-bold text-xs">
                <tr>
                    <th class="px-6 py-3 rounded-l-lg">Product</th>
                    <th class="px-6 py-3">Current Stock</th>
                    <th class="px-6 py-3">Sales Velocity</th>
                    <th class="px-6 py-3">Predicted Stockout</th>
                    <th class="px-6 py-3 rounded-r-lg">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($predictions as $pred)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 font-medium text-white">{{ $pred['name'] }}</td>
                        <td class="px-6 py-4">{{ $pred['stock'] }}</td>
                        <td class="px-6 py-4">{{ $pred['velocity'] }} / day</td>
                        <td class="px-6 py-4 font-mono text-brand-accent">{{ $pred['depletion_date'] }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-bold
                                @if($pred['status'] === 'Critical') bg-red-500/20 text-red-500
                                @elseif($pred['status'] === 'Warning') bg-yellow-500/20 text-yellow-500
                                @else bg-green-500/20 text-green-500 @endif">
                                {{ $pred['status'] }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
