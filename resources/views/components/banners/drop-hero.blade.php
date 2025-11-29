@props(['banner'])

<div x-data="dropHero(@js($banner))" 
     x-init="init()"
     class="relative w-full h-screen overflow-hidden bg-black"
     @mousemove="trackInteraction()">
    
    {{-- Video Background --}}
    @if($banner->media_type === 'video' && $banner->desktop_media_url)
        <video 
            class="absolute inset-0 w-full h-full object-cover"
            autoplay 
            muted 
            loop 
            playsinline
            @play="trackVideoPlay()">
            <source src="{{ $banner->desktop_media_url }}" type="video/mp4">
        </video>
    @elseif($banner->desktop_media_url)
        <img 
            src="{{ $banner->desktop_media_url }}" 
            alt="{{ $banner->title }}"
            class="absolute inset-0 w-full h-full object-cover">
    @endif

    {{-- Overlay --}}
    <div class="absolute inset-0 {{ $banner->overlay_type === 'gradient' ? 'bg-gradient-to-t from-black via-black/70 to-transparent' : '' }}" 
         style="opacity: {{ $banner->overlay_opacity / 100 }}"></div>

    {{-- Content --}}
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="text-center px-6 max-w-4xl {{ $banner->text_position }}">
            
            {{-- Badge --}}
            @if($banner->badge_text)
                <div class="inline-block mb-4 px-4 py-2 bg-brand-accent text-black font-black text-sm uppercase tracking-wider rounded-full animate-pulse">
                    {{ $banner->badge_text }}
                </div>
            @endif

            {{-- Title --}}
            <h1 class="text-6xl md:text-8xl font-black uppercase mb-4 glitch-text" 
                style="color: {{ $banner->text_color ?? '#00FF41' }}"
                data-text="{{ $banner->title }}">
                {{ $banner->title }}
            </h1>

            {{-- Subtitle --}}
            @if($banner->subtitle)
                <p class="text-xl md:text-2xl text-white/90 mb-8 font-light">
                    {{ $banner->subtitle }}
                </p>
            @endif

            {{-- Countdown Timer --}}
            @if($banner->is_drop_active)
                <div class="flex justify-center gap-4 mb-8">
                    <div class="countdown-block">
                        <div class="text-5xl font-black text-brand-accent" x-text="countdown.days">00</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider mt-1">Days</div>
                    </div>
                    <div class="text-5xl font-black text-white/50">:</div>
                    <div class="countdown-block">
                        <div class="text-5xl font-black text-brand-accent" x-text="countdown.hours">00</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider mt-1">Hours</div>
                    </div>
                    <div class="text-5xl font-black text-white/50">:</div>
                    <div class="countdown-block">
                        <div class="text-5xl font-black text-brand-accent" x-text="countdown.minutes">00</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider mt-1">Min</div>
                    </div>
                    <div class="text-5xl font-black text-white/50">:</div>
                    <div class="countdown-block">
                        <div class="text-5xl font-black text-brand-accent" x-text="countdown.seconds">00</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider mt-1">Sec</div>
                    </div>
                </div>
            @endif

            {{-- Stock Alert --}}
            @if($banner->show_stock_ticker && $banner->stock_count)
                <div class="inline-flex items-center gap-2 mb-6 px-4 py-2 bg-red-600/20 border border-red-500 rounded-full text-white">
                    <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                    <span class="text-sm font-bold">Only <span x-text="stockCount">{{ $banner->stock_count }}</span> pieces available</span>
                </div>
            @endif

            {{-- View Count --}}
            @if($banner->show_view_count)
                <div class="inline-flex items-center gap-2 mb-6 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-white text-sm">
                    <span>👀</span>
                    <span><b x-text="viewerCount">0</b> people viewing now</span>
                </div>
            @endif

            {{-- CTA Buttons --}}
            <div class="flex justify-center gap-4">
                @if($banner->notify_enabled && $banner->is_drop_active)
                    <button 
                        @click="notifyMe()"
                        class="px-8 py-4 bg-white/10 backdrop-blur-sm border-2 border-brand-accent text-brand-accent font-black uppercase tracking-wider rounded-lg hover:bg-brand-accent hover:text-black transition-all duration-300 flex items-center gap-2">
                        <span>🔔</span>
                        <span>Notify Me</span>
                    </button>
                @endif

                @if($banner->cta_text && $banner->cta_url)
                    <a 
                        href="{{ $banner->cta_url }}"
                        @click="trackClick()"
                        class="px-8 py-4 bg-brand-accent text-black font-black uppercase tracking-wider rounded-lg hover:shadow-2xl hover:shadow-brand-accent/50 transition-all duration-300 transform hover:scale-105">
                        {{ $banner->cta_text }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Notification Modal --}}
    <div x-show="showNotifyModal" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm"
         @click.self="showNotifyModal = false">
        <div class="bg-gray-900 p-8 rounded-2xl max-w-md w-full mx-4 border border-brand-accent/30">
            <h3 class="text-2xl font-black text-brand-accent mb-4">GET NOTIFIED 🔔</h3>
            <p class="text-gray-400 mb-6">Enter your email to receive notification when this drops!</p>
            
            <form @submit.prevent="submitNotification()">
                <input 
                    type="email" 
                    x-model="email"
                    placeholder="your@email.com"
                    required
                    class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white mb-4 focus:border-brand-accent focus:outline-none">
                
                <button 
                    type="submit"
                    :disabled="submitting"
                    class="w-full px-6 py-3 bg-brand-accent text-black font-bold rounded-lg hover:opacity-90 transition disabled:opacity-50">
                    <span x-show="!submitting">NOTIFY ME</span>
                    <span x-show="submitting">SUBMITTING...</span>
                </button>
            </form>

            <div x-show="notificationSuccess" class="mt-4 p-3 bg-green-900/50 border border-green-500 rounded-lg text-green-200 text-sm">
                ✓ You're on the list! We'll notify you when it drops.
            </div>
        </div>
    </div>
</div>

<script>
function dropHero(banner) {
    return {
        banner: banner,
        countdown: { days: 0, hours: 0, minutes: 0, seconds: 0 },
        stockCount: banner.stock_count,
        viewerCount: 0,
        showNotifyModal: false,
        email: '',
        submitting: false,
        notificationSuccess: false,

        init() {
            if (banner.drop_date) {
                this.startCountdown();
            }
            this.trackImpression();
            this.simulateViewers();
        },

        startCountdown() {
            const updateCountdown = () => {
                const now = new Date().getTime();
                const dropTime = new Date(banner.drop_date).getTime();
                const distance = dropTime - now;

                if (distance < 0) {
                    this.countdown = { days: 0, hours: 0, minutes: 0, seconds: 0 };
                    return;
                }

                this.countdown = {
                    days: Math.floor(distance / (1000 * 60 * 60 * 24)),
                    hours: Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
                    minutes: Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
                    seconds: Math.floor((distance % (1000 * 60)) / 1000)
                };
            };

            updateCountdown();
            setInterval(updateCountdown, 1000);
        },

        trackImpression() {
            fetch(`/api/banners/${banner.id}/impression`, { method: 'POST' })
                .catch(() => {});
        },

        trackClick() {
            fetch(`/api/banners/${banner.id}/click`, { method: 'POST' })
                .catch(() => {});
        },

        trackVideoPlay() {
            fetch(`/api/banners/${banner.id}/video-play`, { method: 'POST' })
                .catch(() => {});
        },

        simulateViewers() {
            this.viewerCount = Math.floor(Math.random() * 50) + 10;
            setInterval(() => {
                this.viewerCount += Math.floor(Math.random() * 3) - 1;
                if (this.viewerCount < 5) this.viewerCount = 5;
            }, 5000);
        },

        notifyMe() {
            this.showNotifyModal = true;
        },

        async submitNotification() {
            this.submitting = true;
            
            try {
                const response = await fetch(`/api/drops/${banner.id}/notify`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email: this.email })
                });

                if (response.ok) {
                    this.notificationSuccess = true;
                    this.email = '';
                    setTimeout(() => {
                        this.showNotifyModal = false;
                        this.notificationSuccess = false;
                    }, 2000);
                }
            } catch (error) {
                console.error('Failed to submit notification:', error);
            } finally {
                this.submitting = false;
            }
        }
    }
}
</script>

<style>
@keyframes glitch {
    0%, 100% { transform: translate(0); }
    25% { transform: translate(-2px, 2px); }
    50% { transform: translate(2px, -2px); }
    75% { transform: translate(-2px, -2px); }
}

.glitch-text {
    position: relative;
    animation: glitch 0.3s ease-in-out infinite;
    text-shadow: 
        2px 2px 0 #FF0055,
        -2px -2px 0 #00FF41;
}

.countdown-block {
    min-width: 80px;
}

[x-cloak] {
    display: none !important;
}
</style>
