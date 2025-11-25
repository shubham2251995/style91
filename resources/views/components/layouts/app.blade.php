@php
    $seoService = new \App\Services\SeoService();
    // Check if we have a product or other model in the view data
    $model = $product ?? null; 
    $seoTags = $seoService->generateTags($model);
    $seoSchema = $seoService->generateSchema($model);
    $navService = new \App\Services\NavigationService();
    $headerLinks = $navService->getHeader();
    $footerColumns = $navService->getFooter();
    
    // Site Settings Service
    $siteSettings = app(\App\Services\SiteSettingsService::class);
    $siteName = $siteSettings->get('site_name', config('app.name', 'Style91'));
    $metaTitle = $siteSettings->get('meta_title', $siteName);
    $metaDescription = $siteSettings->get('meta_description', 'Premium Streetwear Fashion');
    $metaKeywords = $siteSettings->get('meta_keywords', 'streetwear, fashion');
    $ogImage = $siteSettings->get('og_image', '/images/og-default.jpg');
@endphp
<!DOCTYPE html>
            --brand-accent: #FDD835; /* Default (Bewakoof) */
            --brand-dark: #2D2D2D;
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
</head>
<body>
    @livewireStyles
    
    <!-- Top Header (Responsive) -->
    <header class="fixed top-0 left-0 w-full z-50 pointer-events-none">
        <div class="max-w-md md:max-w-full mx-auto bg-white shadow-sm h-14 md:h-16 flex items-center justify-between px-4 md:px-8 lg:px-12 pointer-events-auto">
            <div class="flex items-center gap-4">
                <button class="text-brand-dark md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <a href="{{ route('home') }}" class="font-black text-xl md:text-2xl tracking-tighter text-brand-accent drop-shadow-sm">{{ $siteName }}</a>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center gap-8">
                @foreach($headerLinks as $link)
                    <a href="{{ $link['url'] }}" class="text-brand-dark hover:text-brand-accent font-semibold transition">{{ $link['label'] }}</a>
                @endforeach
            </nav>
            
            <div class="flex items-center gap-3 md:gap-4">
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
                <a href="{{ route('cart') }}" class="text-brand-dark hover:text-brand-accent relative transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 5c.07.277-.029.561-.225.761A1.125 1.125 0 0119.66 15H4.34a1.125 1.125 0 01-.894-1.732l1.263-5a1.125 1.125 0 011.092-.852H18.57c.47 0 .91.247 1.092.852z" />
                    </svg>
                    @if(app(\App\Services\CartService::class)->count() > 0)
                        <span class="absolute -top-2 -right-2 bg-brand-accent text-brand-dark text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                            {{ app(\App\Services\CartService::class)->count() }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </header>
    <main class="pt-16 md:pt-20 pb-24 md:pb-8 min-h-screen bg-brand-gray max-w-md md:max-w-full mx-auto md:shadow-none min-h-screen relative overflow-hidden">
        {{ $slot }}
    </main>

    <!-- Desktop Background (Subtle) -->
    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-gray-50 to-gray-100 hidden md:block"></div>

    <!-- Desktop Footer -->
    <footer class="bg-brand-black text-white pt-20 pb-10 hidden md:block">
        <div class="max-w-7xl mx-auto px-8">
            <div class="grid grid-cols-4 gap-12 mb-16">
                <div>
                    <a href="{{ route('home') }}" class="font-black text-3xl tracking-tighter text-brand-accent mb-6 block">{{ $siteName }}</a>
                    <p class="text-gray-400 text-sm leading-relaxed">{{ $siteSettings->get('footer_text', 'Built for the culture. The ultimate streetwear experience.') }}</p>
                </div>
                
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
    <nav class="md:hidden fixed bottom-0 left-0 w-full z-50 pointer-events-none pb-safe">
        <div class="max-w-md mx-auto bg-white border-t border-gray-200 grid grid-cols-5 h-16 pointer-events-auto">
            <!-- 1. Home -->
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('home') ? 'text-brand-accent' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span class="text-[10px] font-bold mt-1">Home</span>
            </a>
            
            <!-- 2. Explore -->
            <a href="{{ route('lookbook.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('lookbook.*') ? 'text-brand-accent' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('lookbook.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                </svg>
                <span class="text-[10px] font-bold mt-1">Explore</span>
            </a>

            <!-- 3. Swipe (Center) -->
            <div class="relative -top-5">
                <a href="{{ route('swipe') }}" class="flex items-center justify-center w-14 h-14 rounded-full bg-brand-accent text-brand-dark shadow-lg border-4 border-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1.001A3.75 3.75 0 0012 18z" />
                    </svg>
                </a>
            </div>

            <!-- 4. Wardrobe -->
            <a href="{{ route('wardrobe') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('wardrobe') ? 'text-brand-accent' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('wardrobe') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <span class="text-[10px] font-bold mt-1">Wardrobe</span>
            </a>

            <!-- 5. Profile -->
            <a href="{{ auth()->check() ? route('club.dashboard') : route('login') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('club.*') || request()->routeIs('login') ? 'text-brand-accent' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('club.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        :root {
            --brand-black: #0a0a0a;
            --brand-white: #ffffff;
            --brand-gray: #f0f0f0;
            --brand-accent: #FDD835; /* Default (Bewakoof) */
            --brand-dark: #2D2D2D;
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
</head>
<body>
    @livewireStyles
    
    <!-- Top Header (Responsive) -->
    <header class="fixed top-0 left-0 w-full z-50 pointer-events-none">
        <div class="max-w-md md:max-w-full mx-auto bg-white shadow-sm h-14 md:h-16 flex items-center justify-between px-4 md:px-8 lg:px-12 pointer-events-auto">
            <div class="flex items-center gap-4">
                <button class="text-brand-dark md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <a href="{{ route('home') }}" class="font-black text-xl md:text-2xl tracking-tighter text-brand-accent drop-shadow-sm">{{ $siteName }}</a>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center gap-8">
                @foreach($headerLinks as $link)
                    <a href="{{ $link['url'] }}" class="text-brand-dark hover:text-brand-accent font-semibold transition">{{ $link['label'] }}</a>
                @endforeach
            </nav>
            
            <div class="flex items-center gap-3 md:gap-4">
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
                <a href="{{ route('cart') }}" class="text-brand-dark hover:text-brand-accent relative transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 5c.07.277-.029.561-.225.761A1.125 1.125 0 0119.66 15H4.34a1.125 1.125 0 01-.894-1.732l1.263-5a1.125 1.125 0 011.092-.852H18.57c.47 0 .91.247 1.092.852z" />
                    </svg>
                    @if(app(\App\Services\CartService::class)->count() > 0)
                        <span class="absolute -top-2 -right-2 bg-brand-accent text-brand-dark text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                            {{ app(\App\Services\CartService::class)->count() }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </header>
    <main class="pt-16 md:pt-20 pb-24 md:pb-8 min-h-screen bg-brand-gray max-w-md md:max-w-full mx-auto md:shadow-none min-h-screen relative overflow-hidden">
        {{ $slot }}
    </main>

    <!-- Desktop Background (Subtle) -->
    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-gray-50 to-gray-100 hidden md:block"></div>

    <!-- Desktop Footer -->
    <footer class="bg-brand-black text-white pt-20 pb-10 hidden md:block">
        <div class="max-w-7xl mx-auto px-8">
            <div class="grid grid-cols-4 gap-12 mb-16">
                <div>
                    <a href="{{ route('home') }}" class="font-black text-3xl tracking-tighter text-brand-accent mb-6 block">{{ $siteName }}</a>
                    <p class="text-gray-400 text-sm leading-relaxed">{{ $siteSettings->get('footer_text', 'Built for the culture. The ultimate streetwear experience.') }}</p>
                </div>
                
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
    <nav class="md:hidden fixed bottom-0 left-0 w-full z-50 pointer-events-none pb-safe">
        <div class="max-w-md mx-auto bg-white border-t border-gray-200 grid grid-cols-5 h-16 pointer-events-auto">
            <!-- 1. Home -->
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('home') ? 'text-brand-accent' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span class="text-[10px] font-bold mt-1">Home</span>
            </a>
            
            <!-- 2. Explore -->
            <a href="{{ route('lookbook.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('lookbook.*') ? 'text-brand-accent' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('lookbook.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                </svg>
                <span class="text-[10px] font-bold mt-1">Explore</span>
            </a>

            <!-- 3. Swipe (Center) -->
            <div class="relative -top-5">
                <a href="{{ route('swipe') }}" class="flex items-center justify-center w-14 h-14 rounded-full bg-brand-accent text-brand-dark shadow-lg border-4 border-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1.001A3.75 3.75 0 0012 18z" />
                    </svg>
                </a>
            </div>

            <!-- 4. Wardrobe -->
            <a href="{{ route('wardrobe') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('wardrobe') ? 'text-brand-accent' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('wardrobe') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <span class="text-[10px] font-bold mt-1">Wardrobe</span>
            </a>

            <!-- 5. Profile -->
            <a href="{{ auth()->check() ? route('club.dashboard') : route('login') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('club.*') || request()->routeIs('login') ? 'text-brand-accent' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('club.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-[10px] font-bold mt-1">Profile</span>
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
