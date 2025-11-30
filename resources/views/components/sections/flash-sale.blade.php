{{-- Flash Sale Section with Countdown --}}
<section class="py-12 bg-gradient-to-r from-red-600/10 to-orange-600/10 border-y border-red-500/20">
    <div class="container mx-auto px-4">
        {{-- Header with Countdown --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 bg-red-500/20 px-4 py-2 rounded-full mb-4">
                <svg class="w-5 h-5 text-red-400 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"></path>
                </svg>
                <span class="text-red-400 font-bold uppercase text-sm">Flash Sale</span>
            </div>
            
            <h2 class="text-4xl font-bold mb-2">{{ $section->title }}</h2>
            @if($section->subtitle)
            <p class="text-gray-400 text-lg">{{ $section->subtitle }}</p>
            @endif

            @if($section->settings['show_countdown'] ?? false)
            <div class="flex items-center justify-center gap-4 mt-6"
                 x-data="countdown('{{ $section->settings['countdown_date'] }}')"
                 x-init="startCountdown()">
                <div class="bg-black/30 rounded-lg p-4 min-w-[80px]">
                    <div class="text-3xl font-bold text-brand-accent" x-text="days">00</div>
                    <div class="text-xs text-gray-400 uppercase">Days</div>
                </div>
                <div class="text-2xl text-gray-600">:</div>
                <div class="bg-black/30 rounded-lg p-4 min-w-[80px]">
                    <div class="text-3xl font-bold text-brand-accent" x-text="hours">00</div>
                    <div class="text-xs text-gray-400 uppercase">Hours</div>
                </div>
                <div class="text-2xl text-gray-600">:</div>
                <div class="bg-black/30 rounded-lg p-4 min-w-[80px]">
                    <div class="text-3xl font-bold text-brand-accent" x-text="minutes">00</div>
                    <div class="text-xs text-gray-400 uppercase">Mins</div>
                </div>
                <div class="text-2xl text-gray-600">:</div>
                <div class="bg-black/30 rounded-lg p-4 min-w-[80px]">
                    <div class="text-3xl font-bold text-brand-accent" x-text="seconds">00</div>
                    <div class="text-xs text-gray-400 uppercase">Secs</div>
                </div>
            </div>
            @endif
        </div>

        {{-- Products Grid --}}
        @if(isset($section->sectionProducts) && $section->sectionProducts->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-{{ $section->settings['grid_columns'] ?? 4 }} gap-4 md:gap-6">
            @foreach($section->sectionProducts as $product)
            <div class="group bg-white/5 border border-white/10 rounded-xl overflow-hidden hover:border-brand-accent/50 transition-all duration-300 hover:scale-105">
                {{-- Product Image --}}
                <div class="relative aspect-square overflow-hidden bg-gray-800">
                    @if($section->settings['badge_text'] ?? false)
                    <div class="absolute top-3 left-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold z-10">
                        {{ $section->settings['badge_text'] }}
                    </div>
                    @endif
                    
                    <img src="{{ $product->image_url ?? '/images/placeholder.jpg' }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>

                {{-- Product Info --}}
                <div class="p-4">
                    <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $product->name }}</h3>
                    
                    <div class="flex items-center gap-3 mb-3">
                        @if($product->sale_price)
                        <span class="text-2xl font-bold text-brand-accent">₹{{ number_format($product->sale_price) }}</span>
                        <span class="text-gray-400 line-through">₹{{ number_format($product->price) }}</span>
                        <span class="bg-red-500/20 text-red-400 px-2 py-1 rounded text-xs font-bold">
                            -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                        </span>
                        @else
                        <span class="text-2xl font-bold">₹{{ number_format($product->price) }}</span>
                        @endif
                    </div>

                    <a href="{{ route('product', $product->slug) }}" 
                       class="block w-full text-center bg-brand-accent text-black py-2 rounded-lg font-bold hover:bg-blue-500 transition">
                        Shop Now
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
function countdown(endDate) {
    return {
        days: '00',
        hours: '00',
        minutes: '00',
        seconds: '00',
        timer: null,
        
        startCountdown() {
            this.updateCountdown();
            this.timer = setInterval(() => {
                this.updateCountdown();
            }, 1000);
        },
        
        updateCountdown() {
            const end = new Date(endDate).getTime();
            const now = new Date().getTime();
            const distance = end - now;
            
            if (distance < 0) {
                clearInterval(this.timer);
                this.days = this.hours = this.minutes = this.seconds = '00';
                return;
            }
            
            this.days = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
            this.hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
            this.minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
            this.seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
        }
    }
}
</script>
@endpush
