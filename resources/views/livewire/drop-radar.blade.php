<div class="min-h-screen bg-gray-900 pt-20 pb-24 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#3b82f6 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="max-w-6xl mx-auto px-4 relative z-10">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-black text-white mb-2">DROP RADAR</h1>
            <p class="text-gray-400">Live tracking of global drops and pop-ups.</p>
        </div>

        <!-- Radar Visualization -->
        <div class="relative aspect-video bg-black/50 rounded-3xl border border-white/10 overflow-hidden shadow-2xl">
            <!-- Radar Sweep Animation -->
            <div class="absolute inset-0 rounded-full border border-green-500/20 scale-[2]"></div>
            <div class="absolute inset-0 rounded-full border border-green-500/20 scale-[1.5]"></div>
            <div class="absolute inset-0 rounded-full border border-green-500/20 scale-[1]"></div>
            
            <div class="absolute top-1/2 left-1/2 w-[150%] h-[150%] bg-gradient-to-r from-transparent via-green-500/10 to-transparent origin-bottom-left -translate-x-1/2 -translate-y-1/2 animate-spin duration-[4s]"></div>

            <!-- Hotspots -->
            <div class="absolute top-[30%] left-[20%] group cursor-pointer">
                <div class="w-4 h-4 bg-red-500 rounded-full animate-ping absolute"></div>
                <div class="w-4 h-4 bg-red-500 rounded-full relative border-2 border-white"></div>
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 bg-white text-black text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                    NYC Pop-Up (Live)
                </div>
            </div>

            <div class="absolute top-[60%] left-[70%] group cursor-pointer">
                <div class="w-4 h-4 bg-blue-500 rounded-full animate-ping absolute delay-700"></div>
                <div class="w-4 h-4 bg-blue-500 rounded-full relative border-2 border-white"></div>
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 bg-white text-black text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                    Tokyo Drop (2h 15m)
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-white/5 p-6 rounded-xl border border-white/10">
                <h3 class="font-bold text-white mb-2">New York</h3>
                <p class="text-sm text-gray-400">SoHo Flagship</p>
                <p class="text-green-400 text-xs font-mono mt-2">ACTIVE NOW</p>
            </div>
            <div class="bg-white/5 p-6 rounded-xl border border-white/10">
                <h3 class="font-bold text-white mb-2">Tokyo</h3>
                <p class="text-sm text-gray-400">Harajuku Pop-Up</p>
                <p class="text-blue-400 text-xs font-mono mt-2">STARTS IN 2H</p>
            </div>
            <div class="bg-white/5 p-6 rounded-xl border border-white/10">
                <h3 class="font-bold text-white mb-2">London</h3>
                <p class="text-sm text-gray-400">Shoreditch Warehouse</p>
                <p class="text-gray-500 text-xs font-mono mt-2">ENDED</p>
            </div>
        </div>
    </div>
</div>
