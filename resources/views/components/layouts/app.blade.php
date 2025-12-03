    @php
$siteSettings = null;
$headerLinks = [];
$footerColumns = [];
$seoTagsArray = [];
$seoSchema = '';

try {
    // SEO Service
    try {
        $seoService = new \App\Services\SeoService();
        $model = $product ?? null;
        $seoTagsArray = $seoService->generateTags($model);
        $seoSchema = $seoService->generateSchema($model);
    } catch (\Exception $e) {
        // SEO service failed, use defaults
        $seoTagsArray = [];
        $seoSchema = '';
    }
    
    // Navigation Service
    try {
        $navService = new \App\Services\NavigationService();
        $headerLinks = $navService->getHeader();
        $footerColumns = $navService->getFooter();
    } catch (\Exception $e) {
        // Navigation failed, use empty arrays
        $headerLinks = [];
        $footerColumns = [];
    }

    // Site Settings Service - handle pre-installation gracefully
    try {
        $siteSettings = app(\App\Services\SiteSettingsService::class);
        $siteName = $siteSettings->get('site_name', config('app.name', 'Style91'));
        $metaTitle = $seoTagsArray['title'] ?? $siteSettings->get('meta_title', $siteName);
        $metaDescription = $seoTagsArray['description'] ?? $siteSettings->get('meta_description', 'Premium Streetwear Fashion');
        $metaKeywords = $seoTagsArray['keywords'] ?? $siteSettings->get('meta_keywords', 'streetwear, fashion');
        $ogImage = $seoTagsArray['image'] ?? $siteSettings->get('og_image', '/images/og-default.jpg');
        $gaId = $siteSettings->get('google_analytics_id', env('GOOGLE_ANALYTICS_ID'));
        $siteLogo = $siteSettings->get('site_logo', null);
    } catch (\Exception $settingsError) {
        $siteName = config('app.name', 'Style91');
        $metaTitle = $seoTagsArray['title'] ?? $siteName;
        $metaDescription = $seoTagsArray['description'] ?? 'Premium Streetwear Fashion';
        $metaKeywords = $seoTagsArray['keywords'] ?? 'streetwear, fashion';
        $ogImage = $seoTagsArray['image'] ?? '/images/og-default.jpg';
        $gaId = env('GOOGLE_ANALYTICS_ID');
        $siteLogo = null;
    }

    $ogUrl = $seoTagsArray['url'] ?? url()->current();
    $ogType = $seoTagsArray['type'] ?? 'website';
} catch (\Exception $e) {
    // Complete fallback for all initialization failures
    $seoTagsArray = [];
    $seoSchema = '';
    $headerLinks = [];
    $footerColumns = [];
    $siteName = config('app.name', 'Style91');
    $metaTitle = $siteName;
    $metaDescription = 'Premium Streetwear Fashion';
    $metaKeywords = 'streetwear, fashion';
    $ogImage = '/images/og-default.jpg';
    $ogUrl = url()->current();
    $ogType = 'website';
    $gaId = env('GOOGLE_ANALYTICS_ID');
    $siteLogo = null;
}
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle ?? 'Style91' }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    
    
    {{-- Tailwind CSS CDN for Shared Hosting --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Open Graph / Facebook -->
    
    @if($seoSchema)
    <script type="application/ld+json">
    {!! $seoSchema !!}
    </script>
    @endif

    @if(isset($gaId) && $gaId && config('app.env') === 'production')
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $gaId }}');
    </script>
    @endif


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Premium UI Enhancements -->
    <link rel="stylesheet" href="{{ asset('css/premium-ui.css') }}">
    
    <style>
        :root {
            --brand-black: #050505;
            --brand-white: #ffffff;
            --brand-gray: #FAFAFA;
            --brand-accent: #FFE600; /* Vivid Yellow */
            --brand-dark: #1A1A1A;
            --safe-area-bottom: env(safe-area-inset-bottom, 20px);
        }

        [data-theme="veirdo"] {
            --brand-black: #000000;
            --brand-white: #ffffff;
            --brand-gray: #121212;
            --brand-accent: #CCFF00; /* Acid Green */
            --brand-dark: #ffffff;
        }

        [data-theme="default"] {
            --brand-black: #0a0a0a;
            --brand-white: #ffffff;
            --brand-gray: #f3f4f6;
            --brand-accent: #3b82f6; /* Blue */
            --brand-dark: #1f2937;
        }

        .pb-safe {
            padding-bottom: var(--safe-area-bottom);
        }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        brand: {
                            black: 'var(--brand-black)',
                            white: 'var(--brand-white)',
                            gray: 'var(--brand-gray)',
                            accent: 'var(--brand-accent)',
                            dark: 'var(--brand-dark)',
                        }
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
</head>
<body class="font-sans antialiased bg-white text-brand-black" x-data="{ mobileMenuOpen: false, searchOpen: false }">
    
    <!-- Global Lazy Loader -->
    <div wire:loading class="fixed top-0 left-0 w-full h-1 bg-brand-accent z-[100] animate-pulse-fast"></div>


    {{-- Vibrant Youth-Centric Header --}}
    @include('components.header')

    <!-- Main Content -->
    <main class="pt-20 md:pt-24 pb-16 min-h-screen w-full bg-white relative">
        <div class="w-full max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    {{-- Global Add-to-Cart Handler --}}
    @livewire('add-to-cart-handler')

    {{-- Vibrant Footer --}}
    @include('components.footer')

    <!-- Bottom Navigation (Mobile Only) -->
    <nav class="md:hidden fixed bottom-0 left-0 w-full z-50 pb-safe glass-nav">
        <div class="max-w-full mx-auto grid grid-cols-5 h-16 items-center">
            <!-- 1. Home -->
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('home') ? 'text-brand-black' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mb-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span class="text-[10px] font-bold">Home</span>
            </a>
            
            <!-- 2. Explore -->
            @plugin('lookbook')
            <a href="{{ route('lookbook.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('lookbook.*') ? 'text-brand-black' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('lookbook.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mb-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                </svg>
                <span class="text-[10px] font-bold">Explore</span>
            </a>
            @endplugin

            <!-- 3. Swipe (Center) -->
            @plugin('swipe_to_cop')
            <div class="relative -top-6">
                <a href="{{ route('swipe') }}" class="flex items-center justify-center w-14 h-14 rounded-full bg-brand-accent text-brand-black shadow-xl border-4 border-white transform transition-transform active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1.001A3.75 3.75 0 0012 18z" />
                    </svg>
                </a>
            </div>
            @endplugin

            <!-- 4. Wardrobe -->
            @plugin('digital_wardrobe')
            <a href="{{ route('wardrobe') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('wardrobe') ? 'text-brand-black' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('wardrobe') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mb-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <span class="text-[10px] font-bold">Wardrobe</span>
            </a>
            @endplugin

            <!-- 5. Profile -->
            <a href="{{ auth()->check() ? route('club.dashboard') : route('login') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('club.*') || request()->routeIs('login') ? 'text-brand-black' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('club.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mb-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-[10px] font-bold">Profile</span>
            </a>
        </div>
    </nav>
    
    @livewireScripts    
    {{-- Cart Drawer --}}
    <livewire:cart-drawer />

    {{-- Quick View Modal --}}
    <livewire:quick-view />
    
    {{-- Quick View Event Listener --}}
    <script>
        // Listen for quick-view events from product cards
        window.addEventListener('quick-view', event => {
            const productId = event.detail.productId;
            if (productId) {
                Livewire.dispatch('openQuickView', { productId: productId });
            }
        });
    </script>
    
    <!-- Live Chat Integration -->
    <x-live-chat />
</body>
</html>
