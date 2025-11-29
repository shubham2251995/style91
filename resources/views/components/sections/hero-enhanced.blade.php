{{-- Enhanced Hero Section Component --}}
@props(['slides' => null])

<section class="relative w-full h-[90vh] overflow-hidden bg-black" x-data="heroSlider()">
    {{-- Hero Slides --}}
    <div class="relative h-full">
        @if($slides && count($slides) > 0)
            {{-- Dynamic Slides from Database --}}
            @foreach($slides as $index => $slide)
                <div x-show="currentSlide === {{ $index }}"
                     x-transition:enter="transition-opacity duration-700"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity duration-700"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0">
                    
                    {{-- Background Image/Video --}}
                    @if($slide->video_url)
                        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
                            <source src="{{ $slide->video_url }}" type="video/mp4">
                        </video>
                    @else
                        <img src="{{ $slide->image_url }}" 
                             class="absolute inset-0 w-full h-full object-cover object-center transform scale-105 hover:scale-100 transition-transform duration-[10s]" 
                             alt="{{ $slide->title }}">
                    @endif
                    
                    {{-- Gradient Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
                    
                    {{-- Content --}}
                    <div class="absolute inset-0 flex items-center">
                        <div class="max-w-7xl mx-auto px-8 md:px-16 w-full">
                            <div class="max-w-2xl space-y-6">
                                @if($slide->subtitle)
                                    <span class="inline-block bg-brand-accent text-brand-black text-xs md:text-sm font-black tracking-widest uppercase px-4 py-2 animate-pulse">
                                        {{ $slide->subtitle }}
                                    </span>
                                @endif
                                
                                <h1 class="text-white font-black text-5xl md:text-7xl lg:text-8xl leading-none tracking-tighter">
                                    {!! nl2br(e($slide->title)) !!}
                                </h1>
                                
                                @if($slide->description)
                                    <p class="text-gray-300 text-base md:text-xl max-w-xl leading-relaxed">
                                        {{ $slide->description }}
                                    </p>
                                @endif
                                
                                <div class="flex flex-wrap gap-4 pt-4">
                                    @if($slide->cta_text && $slide->cta_url)
                                        <a href="{{ $slide->cta_url }}" 
                                           class="group relative bg-white text-brand-black px-8 py-4 font-black text-sm md:text-base uppercase tracking-widest overflow-hidden transition-all duration-300 hover:bg-brand-accent">
                                            <span class="relative z-10">{{ $slide->cta_text }}</span>
                                            <div class="absolute inset-0 bg-brand-accent transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300"></div>
                                        </a>
                                    @endif
                                    
                                    @if($slide->secondary_cta_text && $slide->secondary_cta_url)
                                        <a href="{{ $slide->secondary_cta_url }}" 
                                           class="border-2 border-white text-white px-8 py-4 font-black text-sm md:text-base uppercase tracking-widest hover:bg-white hover:text-brand-black transition-all duration-300">
                                            {{ $slide->secondary_cta_text }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            {{-- Default Fallback Slide --}}
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1523396870179-16bed9562000?q=80&w=2000&auto=format&fit=crop" 
                     class="absolute inset-0 w-full h-full object-cover object-center" 
                     alt="Hero Background">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
                
                <div class="absolute inset-0 flex items-center">
                    <div class="max-w-7xl mx-auto px-8 md:px-16 w-full">
                        <div class="max-w-2xl space-y-6">
                            <span class="inline-block bg-brand-accent text-brand-black text-xs md:text-sm font-black tracking-widest uppercase px-4 py-2 animate-pulse">
                                New Collection
                            </span>
                            
                            <h1 class="text-white font-black text-5xl md:text-7xl lg:text-8xl leading-none tracking-tighter">
                                STREET<br>CULTURE
                            </h1>
                            
                            <p class="text-gray-300 text-base md:text-xl max-w-xl leading-relaxed">
                                Redefining urban fashion with premium cuts and bold designs. Up to 60% off on selected items.
                            </p>
                            
                            <div class="flex flex-wrap gap-4 pt-4">
                                <a href="{{ route('search') }}" 
                                   class="group relative bg-white text-brand-black px-8 py-4 font-black text-sm md:text-base uppercase tracking-widest overflow-hidden transition-all duration-300 hover:bg-brand-accent">
                                    <span class="relative z-10">Shop The Drop</span>
                                    <div class="absolute inset-0 bg-brand-accent transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300"></div>
                                </a>
                                
                                <a href="{{ route('search') }}" 
                                   class="border-2 border-white text-white px-8 py-4 font-black text-sm md:text-base uppercase tracking-widest hover:bg-white hover:text-brand-black transition-all duration-300">
                                    View Collection
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    {{-- Slide Navigation (if multiple slides) --}}
    @if($slides && count($slides) > 1)
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex gap-3 z-20">
            @foreach($slides as $index => $slide)
                <button @click="goToSlide({{ $index }})"
                        :class="currentSlide === {{ $index }} ? 'w-12 bg-brand-accent' : 'w-3 bg-white/50'"
                        class="h-3 rounded-full transition-all duration-300 hover:bg-white"></button>
            @endforeach
        </div>
        
        {{-- Arrow Navigation --}}
        <button @click="previousSlide()" 
                class="absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-white/10 backdrop-blur-sm text-white p-4 hover:bg-white/20 transition-all duration-300 group">
            <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        
        <button @click="nextSlide()" 
                class="absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-white/10 backdrop-blur-sm text-white p-4 hover:bg-white/20 transition-all duration-300 group">
            <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    @endif
    
    {{-- Scroll Indicator --}}
    <div class="absolute bottom-8 left-8 z-20 hidden md:block">
        <div class="flex items-center gap-2 text-white/60 text-sm uppercase tracking-wider">
            <span>Scroll</span>
            <svg class="w-4 h-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </div>
</section>

<script>
function heroSlider() {
    return {
        currentSlide: 0,
        totalSlides: {{ $slides ? count($slides) : 1 }},
        autoplayInterval: null,
        
        init() {
            if (this.totalSlides > 1) {
                this.startAutoplay();
            }
        },
        
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
            this.resetAutoplay();
        },
        
        previousSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
            this.resetAutoplay();
        },
        
        goToSlide(index) {
            this.currentSlide = index;
            this.resetAutoplay();
        },
        
        startAutoplay() {
            this.autoplayInterval = setInterval(() => {
                this.nextSlide();
            }, 8000); // Change slide every 8 seconds
        },
        
        resetAutoplay() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
                this.startAutoplay();
            }
        }
    }
}
</script>
