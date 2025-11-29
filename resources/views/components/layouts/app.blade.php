    @php
$siteSettings = null;
try {
    $seoService = new \App\Services\SeoService();
    $model = $product ?? null;
    $seoTagsArray = $seoService->generateTags($model);
    $seoSchema = $seoService->generateSchema($model);
    $navService = new \App\Services\NavigationService();
    $headerLinks = $navService->getHeader();
    $footerColumns = $navService->getFooter();

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
    // Fallback for installation or DB issues
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

    <title>{{ $metaTitle ?? 'Style91' }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    
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
    <script src="https://cdn.tailwindcss.com"></script>
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
    @livewireStyles
</head>
<body class="font-sans antialiased bg-white text-brand-black">
    <!-- Header -->
    <header class="fixed top-0 left-0 w-full z-50 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 md:px-8 h-16 md:h-20 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <!-- Mobile Menu Button -->
                <button type="button" class="md:hidden text-brand-dark hover:text-brand-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <a href="{{ route('home') }}" class="font-black text-xl md:text-2xl tracking-tighter text-brand-black hover:text-brand-accent transition-colors duration-300">
                    @if(isset($siteLogo) && $siteLogo)
                        <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="h-8 md:h-10 w-auto">
                    @else
                        {{ $siteName }}<span class="text-brand-accent">.</span>
                    @endif
                </a>
            </div>

            <!-- Gender Toggle (Desktop) -->
            <div class="hidden md:flex items-center gap-4 ml-8">
                <a href="{{ route('search', ['gender' => 'Men']) }}" class="text-sm font-bold uppercase tracking-wider {{ request('gender') == 'Men' ? 'text-brand-black border-b-2 border-brand-accent' : 'text-gray-500 hover:text-brand-black' }}">Men</a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('search', ['gender' => 'Women']) }}" class="text-sm font-bold uppercase tracking-wider {{ request('gender') == 'Women' ? 'text-brand-black border-b-2 border-brand-accent' : 'text-gray-500 hover:text-brand-black' }}">Women</a>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center gap-8">
                @if(isset($headerMenu) && $headerMenu->items->count() > 0)
                    @foreach($headerMenu->tree() as $item)
                        <div class="relative group">
                            <a href="{{ $item->link }}" target="{{ $item->target }}" class="text-brand-dark hover:text-brand-accent font-bold text-sm uppercase tracking-wide transition flex items-center gap-1">
                                {{ $item->title }}
                                @if($item->children->count() > 0)
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                @endif
                            </a>
                            @if($item->children->count() > 0)
                                <div class="absolute top-full left-0 mt-2 w-48 bg-white border border-gray-100 shadow-lg rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    @foreach($item->children as $child)
                                        <a href="{{ $child->link }}" target="{{ $child->target }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-brand-accent">{{ $child->title }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    @foreach($headerLinks as $link)
                        <a href="{{ $link['url'] }}" class="text-brand-dark hover:text-brand-accent font-bold text-sm uppercase tracking-wide transition">{{ $link['label'] }}</a>
                    @endforeach
                @endif
            </nav>
            
            <div class="flex items-center gap-3 md:gap-6">
                <!-- Search -->
                <a href="{{ route('search') }}" class="text-brand-dark hover:text-brand-accent transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </a>

                <!-- Wishlist -->
                @auth
                    <a href="{{ route('wishlist') }}" class="text-brand-dark hover:text-brand-accent transition hidden md:block">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                    </a>

                    <!-- Account -->
                    <a href="{{ route('account') }}" class="text-brand-dark hover:text-brand-accent transition hidden md:block">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </a>
                @endauth

                <!-- Cart -->
                <a href="{{ route('cart') }}" class="text-brand-dark hover:text-brand-accent relative transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 group-hover:scale-110 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 5c.07.277-.029.561-.225.761A1.125 1.125 0 0119.66 15H4.34a1.125 1.125 0 01-.894-1.732l1.263-5a1.125 1.125 0 011.092-.852H18.57c.47 0 .91.247 1.092.852z" />
                    </svg>
                    @if(app(\App\Services\CartService::class)->count() > 0)
                        <span class="absolute -top-2 -right-2 bg-brand-accent text-brand-black text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm">
                            {{ app(\App\Services\CartService::class)->count() }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-16 md:pt-20 pb-24 md:pb-12 min-h-screen w-full max-w-7xl mx-auto relative">
        {{ $slot }}
    </main>

    <!-- Desktop Background (Subtle) -->
    <div class="fixed inset-0 -z-10 bg-brand-gray hidden md:block"></div>

    <!-- Desktop Footer -->
    <footer class="bg-brand-black text-white pt-20 pb-10 hidden md:block">
        <div class="max-w-7xl mx-auto px-8">
            <div class="grid grid-cols-4 gap-12 mb-16">
                <div>
                    <a href="{{ route('home') }}" class="font-black text-3xl tracking-tighter text-brand-accent mb-6 block">{{ $siteName }}</a>
                    <p class="text-gray-400 text-sm leading-relaxed">{{ $siteSettings ? $siteSettings->get('footer_text', 'Built for the culture. The ultimate streetwear experience.') : 'Built for the culture. The ultimate streetwear experience.' }}</p>
                </div>
                
                @if(isset($footerMenu1) || isset($footerMenu2))
                    @if(isset($footerMenu1))
                        <div>
                            <h4 class="font-bold text-lg mb-6">{{ $footerMenu1->name }}</h4>
                            <ul class="space-y-4 text-sm text-gray-400">
                                @foreach($footerMenu1->items as $link)
                                <li><a href="{{ $link->link }}" target="{{ $link->target }}" class="hover:text-brand-accent transition-colors">{{ $link->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(isset($footerMenu2))
                        <div>
                            <h4 class="font-bold text-lg mb-6">{{ $footerMenu2->name }}</h4>
                            <ul class="space-y-4 text-sm text-gray-400">
                                @foreach($footerMenu2->items as $link)
                                <li><a href="{{ $link->link }}" target="{{ $link->target }}" class="hover:text-brand-accent transition-colors">{{ $link->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    {{-- Default Static Column if needed or just keep dynamic --}}
                    <div>
                        <h4 class="font-bold text-lg mb-6">Customer Care</h4>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li><a href="{{ route('contact') }}" class="hover:text-brand-accent transition-colors">Contact Us</a></li>
                            <li><a href="{{ route('shipping') }}" class="hover:text-brand-accent transition-colors">Shipping & Returns</a></li>
                            <li><a href="{{ route('size-guide') }}" class="hover:text-brand-accent transition-colors">Size Guide</a></li>
                            <li><a href="{{ route('track-order') }}" class="hover:text-brand-accent transition-colors">Track Order</a></li>
                        </ul>
                    </div>
                @else
                    @foreach($footerColumns as $column)
                    <div>
                        <h4 class="font-bold text-lg mb-6">{{ $column['title'] }}</h4>
                        <ul class="space-y-4 text-sm text-gray-400">
                            @foreach($column['links'] as $link)
                            <li><a href="{{ $link['url'] }}" class="hover:text-brand-accent transition-colors">{{ $link['label'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                @endif
            </div>
            
            <div class="border-t border-white/10 pt-8 flex justify-between items-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition-colors">Instagram</a>
                    <a href="#" class="hover:text-white transition-colors">Twitter</a>
                    <a href="#" class="hover:text-white transition-colors">Discord</a>
                </div>
            </div>
        </div>
    </footer>

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
    <!-- Quick View Modal (Global) -->
    <livewire:quick-view />
    
    <!-- Live Chat Integration -->
    <x-live-chat />
</body>
</html>
