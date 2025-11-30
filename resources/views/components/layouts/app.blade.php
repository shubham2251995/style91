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
<body class="font-sans antialiased bg-white text-brand-black" x-data="{ mobileMenuOpen: false, searchOpen: false }">
    
    <!-- Global Lazy Loader -->
    <div wire:loading class="fixed top-0 left-0 w-full h-1 bg-brand-accent z-[100] animate-pulse-fast"></div>

    <!-- Mobile Menu Drawer (Bewkoof Style) -->
    <div x-show="mobileMenuOpen" style="display: none;" class="fixed inset-0 z-[60] flex" role="dialog" aria-modal="true">
        <!-- Overlay -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/50 backdrop-blur-sm" 
             @click="mobileMenuOpen = false"></div>

        <!-- Drawer Panel -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative flex-1 flex flex-col max-w-xs w-full bg-white h-full shadow-2xl">
            
            <!-- Drawer Header (User Info) -->
            <div class="p-4 bg-brand-gray border-b border-gray-100 flex items-center justify-between">
                @auth
                    <a href="{{ route('account') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-brand-accent flex items-center justify-center text-brand-black font-bold text-lg">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-sm">Hey, {{ explode(' ', auth()->user()->name)[0] }}</p>
                            <p class="text-xs text-gray-500">View Profile</p>
                        </div>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm">Login / Sign Up</p>
                            <p class="text-xs text-brand-accent font-medium">Get exclusive offers!</p>
                        </div>
                    </a>
                @endauth
                <button @click="mobileMenuOpen = false" class="p-2 text-gray-400 hover:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Gender Toggle (Bewkoof Style) -->
            <div class="flex border-b border-gray-100">
                <a href="{{ route('search', ['gender' => 'Men']) }}" class="flex-1 py-3 text-center font-bold text-sm uppercase tracking-wider {{ request('gender') == 'Men' ? 'bg-white text-brand-black border-b-2 border-brand-accent' : 'bg-gray-50 text-gray-500' }}">
                    Men
                </a>
                <a href="{{ route('search', ['gender' => 'Women']) }}" class="flex-1 py-3 text-center font-bold text-sm uppercase tracking-wider {{ request('gender') == 'Women' ? 'bg-white text-brand-black border-b-2 border-brand-accent' : 'bg-gray-50 text-gray-500' }}">
                    Women
                </a>
            </div>

            <!-- Menu Items -->
            <div class="flex-1 overflow-y-auto py-2">
                <nav class="space-y-1">
                    @if(isset($headerMenu) && $headerMenu->items->count() > 0)
                        @foreach($headerMenu->tree() as $item)
                            <div x-data="{ open: false }">
                                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-brand-black">
                                    <span class="flex items-center gap-3">
                                        {{-- Optional Icon Logic could go here --}}
                                        {{ $item->title }}
                                    </span>
                                    @if($item->children->count() > 0)
                                        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    @endif
                                </button>
                                @if($item->children->count() > 0)
                                    <div x-show="open" x-collapse class="bg-gray-50 px-4 py-2 space-y-1">
                                        @foreach($item->children as $child)
                                            <a href="{{ $child->link }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-brand-accent">{{ $child->title }}</a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback Links -->
                        <a href="{{ route('new-arrivals') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50">New Arrivals</a>
                        <a href="{{ route('sale') }}" class="block px-4 py-3 text-sm font-medium text-red-600 hover:bg-gray-50">Sale</a>
                        <a href="{{ route('track-order') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50">Track Order</a>
                    @endif
                </nav>

                <!-- Other Links -->
                <div class="mt-4 border-t border-gray-100 pt-4">
                    <a href="{{ route('contact') }}" class="block px-4 py-3 text-sm text-gray-500 hover:text-brand-black">Contact Us</a>
                    <a href="{{ route('track-order') }}" class="block px-4 py-3 text-sm text-gray-500 hover:text-brand-black">Track Order</a>
                    <a href="{{ route('size-guide') }}" class="block px-4 py-3 text-sm text-gray-500 hover:text-brand-black">Size Guide</a>
                </div>
            </div>

            <!-- Drawer Footer -->
            @auth
                <div class="p-4 border-t border-gray-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-2 text-center text-sm font-bold text-red-500 hover:bg-red-50 rounded-lg transition">
                            Logout
                        </button>
                    </form>
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
                    <a href="{{ route('size-guide') }}" class="block px-4 py-3 text-sm text-gray-500 hover:text-brand-black">Size Guide</a>
                </div>
            </div>

            <!-- Drawer Footer -->
            @auth
                <div class="p-4 border-t border-gray-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-2 text-center text-sm font-bold text-red-500 hover:bg-red-50 rounded-lg transition">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>

    {{-- Vibrant Youth-Centric Header --}}
    @include('components.header-vibrant')

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
