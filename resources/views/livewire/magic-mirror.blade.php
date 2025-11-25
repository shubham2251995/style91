<div class="min-h-screen bg-black flex flex-col items-center justify-center p-4">
    <div class="relative w-full max-w-md aspect-[9/16] bg-gray-900 rounded-3xl overflow-hidden border-4 border-white/20 shadow-2xl">
        <!-- Camera Feed Simulation -->
        <div class="absolute inset-0 bg-gray-800 flex items-center justify-center">
            <p class="text-gray-500 animate-pulse">Initializing Camera...</p>
        </div>
        
        <!-- AR Overlay -->
        <div class="absolute inset-0 pointer-events-none z-10 flex flex-col justify-between p-6">
            <div class="flex justify-between items-start">
                <div class="bg-black/50 backdrop-blur px-3 py-1 rounded-full text-xs text-white">LIVE AR</div>
                <div class="bg-black/50 backdrop-blur px-3 py-1 rounded-full text-xs text-white">US7 FILTER</div>
            </div>
            
            <!-- Product Overlay (Mock) -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 opacity-80">
                <img src="https://pngimg.com/uploads/sunglasses/sunglasses_PNG143.png" class="w-full drop-shadow-2xl">
            </div>

            <div class="flex justify-center gap-4 pointer-events-auto">
                <button class="w-12 h-12 rounded-full bg-white/20 backdrop-blur flex items-center justify-center text-white hover:bg-white/40">
                    ←
                </button>
                <button class="w-16 h-16 rounded-full border-4 border-white flex items-center justify-center">
                    <div class="w-12 h-12 bg-white rounded-full"></div>
                </button>
                <button class="w-12 h-12 rounded-full bg-white/20 backdrop-blur flex items-center justify-center text-white hover:bg-white/40">
                    →
                </button>
            </div>
        </div>
    </div>
    <p class="text-gray-500 mt-4 text-sm">Allow camera access for Magic Mirror experience.</p>
</div>
