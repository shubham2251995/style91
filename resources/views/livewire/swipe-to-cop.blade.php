<div class="min-h-screen bg-black flex flex-col items-center justify-center overflow-hidden relative">
    <!-- Background Elements -->
    <div class="absolute inset-0 bg-gradient-to-b from-purple-900/20 to-black pointer-events-none"></div>
    
    <div class="text-center mb-8 z-10">
        <h1 class="text-3xl font-black text-white italic tracking-tighter">SWIPE<span class="text-brand-accent">2</span>COP</h1>
        <p class="text-gray-500 text-sm">Right to Cop. Left to Drop.</p>
    </div>

    @if($currentProduct)
        <div class="relative w-full max-w-sm aspect-[3/4] perspective-1000">
            <!-- Card -->
            <div 
                x-data="{ 
                    startX: 0, 
                    currentX: 0,
                    isDragging: false,
                    rotate: 0,
                    opacity: 1,
                    startDrag(e) {
                        this.startX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                        this.isDragging = true;
                    },
                    drag(e) {
                        if (!this.isDragging) return;
                        const x = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                        this.currentX = x - this.startX;
                        this.rotate = this.currentX / 10;
                    },
                    endDrag() {
                        this.isDragging = false;
                        if (this.currentX > 100) {
                            $wire.swipeRight();
                        } else if (this.currentX < -100) {
                            $wire.swipeLeft();
                        }
                        this.currentX = 0;
                        this.rotate = 0;
                    }
                }"
                @mousedown="startDrag"
                @mousemove.window="drag"
                @mouseup.window="endDrag"
                @touchstart="startDrag"
                @touchmove.window="drag"
                @touchend.window="endDrag"
                :style="`transform: translateX(${currentX}px) rotate(${rotate}deg); opacity: ${opacity}`"
                class="absolute inset-0 bg-gray-900 rounded-3xl overflow-hidden shadow-2xl cursor-grab active:cursor-grabbing transition-transform duration-75"
            >
                <img src="{{ $currentProduct->image_url }}" class="w-full h-full object-cover pointer-events-none">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                
                <div class="absolute bottom-0 left-0 w-full p-8 pointer-events-none">
                    <h2 class="text-3xl font-black text-white leading-none mb-2">{{ $currentProduct->name }}</h2>
                    <p class="text-brand-accent font-mono text-xl font-bold">${{ $currentProduct->price }}</p>
                </div>

                <!-- Overlay Indicators -->
                <div class="absolute top-8 left-8 border-4 border-green-500 text-green-500 font-black text-4xl px-4 py-2 rounded-lg transform -rotate-12 opacity-0" :style="`opacity: ${currentX > 50 ? (currentX-50)/100 : 0}`">
                    COP
                </div>
                <div class="absolute top-8 right-8 border-4 border-red-500 text-red-500 font-black text-4xl px-4 py-2 rounded-lg transform rotate-12 opacity-0" :style="`opacity: ${currentX < -50 ? -(currentX+50)/100 : 0}`">
                    DROP
                </div>
            </div>
        </div>

        <!-- Controls -->
        <div class="flex gap-6 mt-12 z-10">
            <button wire:click="swipeLeft" class="w-16 h-16 rounded-full bg-gray-800 text-red-500 flex items-center justify-center hover:bg-gray-700 hover:scale-110 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <button wire:click="swipeRight" class="w-16 h-16 rounded-full bg-brand-accent text-white flex items-center justify-center hover:bg-blue-600 hover:scale-110 transition-all shadow-[0_0_30px_rgba(59,130,246,0.5)]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
            </button>
        </div>

    @else
        <div class="text-center z-10">
            <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-white mb-2">You've seen it all!</h2>
            <p class="text-gray-500 mb-8">Check back later for more drops.</p>
            <a href="{{ route('home') }}" class="bg-white text-black font-bold px-8 py-3 rounded-full hover:bg-gray-200 transition-colors">
                Back to Home
            </a>
        </div>
    @endif
</div>
