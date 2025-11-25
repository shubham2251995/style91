<!-- Global Lazy Loader -->
<div 
    wire:loading 
    class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[9999] flex items-center justify-center"
    wire:loading.class="opacity-100"
    wire:loading.class.remove="opacity-0 pointer-events-none"
    class="opacity-0 pointer-events-none transition-opacity duration-300"
>
    <div class="text-center">
        <!-- Loader Icon/Animation -->
        <div class="relative inline-block">
            @php
                $loaderType = \App\Models\SiteSetting::get('loader_type', 'spinner');
                $loaderColor = \App\Models\SiteSetting::get('loader_color', '#FFE600');
            @endphp

            @if($loaderType === 'spinner')
                <!-- Spinning Circle Loader -->
                <div class="w-16 h-16 border-4 border-t-transparent rounded-full animate-spin" style="border-color: {{ $loaderColor }} {{ $loaderColor }} transparent {{ $loaderColor }};"></div>
            @elseif($loaderType === 'dots')
                <!-- Bouncing Dots Loader -->
                <div class="flex gap-2">
                    <div class="w-4 h-4 rounded-full animate-bounce" style="background-color: {{ $loaderColor }}; animation-delay: 0ms;"></div>
                    <div class="w-4 h-4 rounded-full animate-bounce" style="background-color: {{ $loaderColor }}; animation-delay: 150ms;"></div>
                    <div class="w-4 h-4 rounded-full animate-bounce" style="background-color: {{ $loaderColor }}; animation-delay: 300ms;"></div>
                </div>
            @elseif($loaderType === 'pulse')
                <!-- Pulsing Circle Loader -->
                <div class="relative">
                    <div class="w-16 h-16 rounded-full animate-ping absolute" style="background-color: {{ $loaderColor }}; opacity: 0.75;"></div>
                    <div class="w-16 h-16 rounded-full" style="background-color: {{ $loaderColor }};"></div>
                </div>
            @elseif($loaderType === 'bars')
                <!-- Animated Bars Loader -->
                <div class="flex gap-1 items-end h-16">
                    <div class="w-2 rounded-full animate-pulse" style="background-color: {{ $loaderColor }}; height: 20%; animation-duration: 0.8s;"></div>
                    <div class="w-2 rounded-full animate-pulse" style="background-color: {{ $loaderColor }}; height: 60%; animation-duration: 1s; animation-delay: 0.1s;"></div>
                    <div class="w-2 rounded-full animate-pulse" style="background-color: {{ $loaderColor }}; height: 100%; animation-duration: 1.2s; animation-delay: 0.2s;"></div>
                    <div class="w-2 rounded-full animate-pulse" style="background-color: {{ $loaderColor }}; height: 60%; animation-duration: 1s; animation-delay: 0.3s;"></div>
                    <div class="w-2 rounded-full animate-pulse" style="background-color: {{ $loaderColor }}; height: 20%; animation-duration: 0.8s; animation-delay: 0.4s;"></div>
                </div>
            @else
                <!-- Default: Logo Loader -->
                <div class="w-20 h-20 flex items-center justify-center">
                    @php
                        $logo = \App\Models\SiteSetting::get('logo_url');
                    @endphp
                    @if($logo)
                        <img src="{{ $logo }}" alt="Loading" class="max-w-full max-h-full animate-pulse">
                    @else
                        <div class="w-16 h-16 border-4 border-t-transparent rounded-full animate-spin" style="border-color: {{ $loaderColor }} {{ $loaderColor }} transparent {{ $loaderColor }};"></div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Loading Text -->
        <p class="mt-4 text-white font-bold text-sm uppercase tracking-widest">
            {{ \App\Models\SiteSetting::get('loader_text', 'Loading...') }}
        </p>
    </div>
</div>

<!-- Page Transition Loader -->
<div 
    x-data="{ loading: false }"
    x-on:page-loading.window="loading = true"
    x-on:page-loaded.window="loading = false"
    x-show="loading"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[9998] flex items-center justify-center"
    style="display: none;"
>
    <div class="text-center">
        @php
            $loaderType = \App\Models\SiteSetting::get('loader_type', 'spinner');
            $loaderColor = \App\Models\SiteSetting::get('loader_color', '#FFE600');
        @endphp

        <div class="relative inline-block">
            @if($loaderType === 'spinner')
                <div class="w-16 h-16 border-4 border-t-transparent rounded-full animate-spin" style="border-color: {{ $loaderColor }} {{ $loaderColor }} transparent {{ $loaderColor }};"></div>
            @elseif($loaderType === 'dots')
                <div class="flex gap-2">
                    <div class="w-4 h-4 rounded-full animate-bounce" style="background-color: {{ $loaderColor }}; animation-delay: 0ms;"></div>
                    <div class="w-4 h-4 rounded-full animate-bounce" style="background-color: {{ $loaderColor }}; animation-delay: 150ms;"></div>
                    <div class="w-4 h-4 rounded-full animate-bounce" style="background-color: {{ $loaderColor }}; animation-delay: 300ms;"></div>
                </div>
            @else
                <div class="w-16 h-16 border-4 border-t-transparent rounded-full animate-spin" style="border-color: {{ $loaderColor }} {{ $loaderColor }} transparent {{ $loaderColor }};"></div>
            @endif
        </div>

        <p class="mt-4 text-white font-bold text-sm uppercase tracking-widest">
            {{ \App\Models\SiteSetting::get('loader_text', 'Loading...') }}
        </p>
    </div>
</div>

<script>
    // Trigger page loading events on navigation
    document.addEventListener('livewire:navigating', () => {
        window.dispatchEvent(new CustomEvent('page-loading'));
    });

    document.addEventListener('livewire:navigated', () => {
        window.dispatchEvent(new CustomEvent('page-loaded'));
    });
</script>
