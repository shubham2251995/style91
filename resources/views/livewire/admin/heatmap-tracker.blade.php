<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-white">Heatmap Tracker</h2>

    <div class="mb-6">
        <label class="block text-sm font-bold text-gray-400 mb-2">Select Page</label>
        <select wire:model.live="page" class="bg-black border border-white/20 rounded-lg px-4 py-2 text-white">
            <option value="/">Home</option>
            <option value="/shop">Shop</option>
            <option value="/cart">Cart</option>
        </select>
    </div>

    <div class="relative bg-white/5 rounded-xl aspect-video flex items-center justify-center border border-dashed border-white/20">
        <p class="text-gray-500">
            Heatmap visualization requires frontend tracking script integration.
            <br>
            Currently showing {{ $clicks->count() }} recorded clicks for this page.
        </p>
        
        <!-- Mock visualization -->
        @foreach($clicks as $click)
            <div class="absolute w-4 h-4 bg-red-500/50 rounded-full blur-sm" style="top: {{ $click->y }}%; left: {{ $click->x }}%;"></div>
        @endforeach
    </div>
</div>
