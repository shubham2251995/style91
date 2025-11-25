<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-white">Channel Vision</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-500/10 border border-blue-500/20 p-6 rounded-xl">
            <h3 class="text-blue-500 font-bold mb-2">Mobile App</h3>
            <p class="text-3xl font-black text-white">45%</p>
            <p class="text-xs text-gray-400">of total revenue</p>
        </div>
        <div class="bg-purple-500/10 border border-purple-500/20 p-6 rounded-xl">
            <h3 class="text-purple-500 font-bold mb-2">Instagram Shop</h3>
            <p class="text-3xl font-black text-white">28%</p>
            <p class="text-xs text-gray-400">high conversion</p>
        </div>
        <div class="bg-green-500/10 border border-green-500/20 p-6 rounded-xl">
            <h3 class="text-green-500 font-bold mb-2">Desktop Web</h3>
            <p class="text-3xl font-black text-white">20%</p>
            <p class="text-xs text-gray-400">high AOV</p>
        </div>
        <div class="bg-orange-500/10 border border-orange-500/20 p-6 rounded-xl">
            <h3 class="text-orange-500 font-bold mb-2">TikTok</h3>
            <p class="text-3xl font-black text-white">7%</p>
            <p class="text-xs text-gray-400">fastest growing</p>
        </div>
    </div>

    <!-- Chart Placeholder -->
    <div class="bg-white/5 p-6 rounded-xl border border-white/10 h-64 flex items-end justify-between gap-2">
        @foreach([45, 28, 20, 7] as $val)
            <div class="w-full bg-brand-accent/50 hover:bg-brand-accent transition-colors rounded-t-lg relative group" style="height: {{ $val * 2 }}%">
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                    {{ $val }}%
                </div>
            </div>
        @endforeach
    </div>
</div>
