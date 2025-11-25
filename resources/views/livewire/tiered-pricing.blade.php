<div class="mt-6 border-t border-white/10 pt-6">
    <h3 class="text-sm font-bold text-gray-400 uppercase mb-3">Bulk Discounts</h3>
    <div class="grid grid-cols-3 gap-2">
        @foreach($tiers as $tier)
            <div class="bg-white/5 border border-white/10 rounded-lg p-3 text-center">
                <p class="text-lg font-bold text-white">{{ $tier->min_quantity }}+</p>
                <p class="text-xs text-green-400 font-mono">{{ $tier->discount_percentage }}% OFF</p>
            </div>
        @endforeach
    </div>
</div>
