{{-- Vibrant Youth-Centric Header --}}
<header class="fixed top-0 left-0 w-full z-50" x-data="{ scrolled: false, mobileMenuOpen: false, searchOpen: false }" 
        @scroll.window="scrolled = window.scrollY > 50">
    
    {{-- Promo Bar --}}
    <div class="bg-gradient-to-r from-brand-500 to-accent-500 text-black py-2 px-4 text-center font-bold text-sm animate-pulse-fast">
        <div class="flex items-center justify-center gap-2">
            <svg class="w-4 h-4 animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                <path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"></path>
            </svg>
            <span>🔥 MEGA SALE: Get 50% OFF + Free Shipping on Orders Above ₹999!</span>
            <svg class="w-4 h-4 animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                <path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"></path>
            </svg>
        </div>
    </div>

    {{-- Main Header --}}
    <div class="transition-all duration-300"
         :class="scrolled ? 'bg-black/95 backdrop-blur-xl shadow-glow-yellow' : 'bg-black/80 backdrop-blur-md'">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16 md:h-20">
                
                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = true" class="md:hidden text-white hover:text-brand-500 p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="text-3xl md:text-4xl font-black tracking-tighter">
                        <span class="text-white group-hover:text-brand-500 transition-colors duration-300">STYLE</span><span class="text-gradient-vibrant">91</span>
                    </div>
                    <span class="bg-gradient-to-r from-brand-500 to-accent-500 text-black text-xs font-bold px-2 py-1 rounded-full uppercase animate-pulse">New</span>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center gap-6 lg:gap-8">
                    <a href="{{ route('new-arrivals') }}" class="relative group text-white hover:text-brand-500 transition-colors font-bold text-sm uppercase">
                        New Arrivals
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-brand-500 to-accent-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="{{ route('products.index') }}" class="relative group text-white hover:text-brand-500 transition-colors font-bold text-sm uppercase">
                        Shop All
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-brand-500 to-accent-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="{{ route('sale') }}" class="relative group flex items-center gap-2">
                        <span class="text-brand-500 font-black text-sm uppercase animate-pulse">Sale</span>
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full animate-bounce">50%</span>
                    </a>
                    <a href="{{ route('vault') }}" class="relative group text-electric-500 hover:text-electric-400 transition-colors font-bold text-sm uppercase">
                        Exclusive
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-electric-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                </nav>

                {{-- Action Icons --}}
                <div class="flex items-center gap-3 md:gap-4">
                    {{-- Search --}}
                    <button @click="searchOpen = !searchOpen" class="text-white hover:text-brand-500 transition-colors p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>

                    {{-- Wishlist --}}
                    @auth
                    <a href="{{ route('wishlist') }}" class="relative text-white hover:text-brand-500 transition-colors p-2 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-electric-500 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ auth()->user()->wishlistCount ?? 0 }}</span>
                    </a>
                    @endauth

                    {{-- Cart --}}
                    <a href="{{ route('cart.index') }}" class="relative text-white hover:text-brand-500 transition-colors p-2 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-brand-500 to-accent-500 text-black text-xs font-bold rounded-full flex items-center justify-center animate-pulse">{{ session('cart_count', 0) }}</span>
                    </a>

                    {{-- Account --}}
                    @auth
                    <a href="{{ route('profile') }}" class="hidden md:flex items-center gap-2 bg-white/10 hover:bg-brand-500/20 px-4 py-2 rounded-full transition-all border border-white/20 hover:border-brand-500">
                        <svg class="w-5 h-5 text-brand-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-white font-medium text-sm">{{ auth()->user()->name }}</span>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="hidden md:block btn-primary text-sm px-4 py-2">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- Search Overlay --}}
    <div x-show="searchOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         @click.away="searchOpen = false"
         class="absolute top-full left-0 w-full bg-black/95 backdrop-blur-xl border-t border-brand-500/30 py-6 px-4 shadow-glow-yellow">
        <div class="container mx-auto max-w-2xl">
            <input type="text" 
                   placeholder="Search for products, brands, categories..."
                   class="w-full bg-white/10 border-2 border-brand-500/50 rounded-xl px-6 py-4 text-white placeholder-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/50 transition-all text-lg">
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         @click="mobileMenuOpen = false"
         class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 md:hidden">
        <div @click.stop class="w-80 h-full bg-gradient-to-b from-black to-gray-900 shadow-glow-yellow overflow-y-auto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0">
            
            <div class="p-6 border-b border-brand-500/30">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-2xl font-black text-gradient-vibrant">STYLE91</span>
                    <button @click="mobileMenuOpen = false" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                @auth
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-brand-500 to-accent-500 rounded-full flex items-center justify-center text-black font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-white font-bold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="block text-center btn-primary w-full">Login / Sign Up</a>
                @endauth
            </div>

            <nav class="py-4">
                <a href="{{ route('new-arrivals') }}" class="block px-6 py-3 text-white hover:bg-brand-500/20 hover:text-brand-500 transition font-medium">New Arrivals</a>
                <a href="{{ route('products.index') }}" class="block px-6 py-3 text-white hover:bg-brand-500/20 hover:text-brand-500 transition font-medium">Shop All</a>
                <a href="{{ route('sale') }}" class="block px-6 py-3 text-brand-500 hover:bg-brand-500/20 transition font-bold">🔥 Sale - 50% OFF</a>
                <a href="{{ route('vault') }}" class="block px-6 py-3 text-electric-500 hover:bg-electric-500/20 transition font-medium">Exclusive Drops</a>
                <a href="{{ route('track-order') }}" class="block px-6 py-3 text-white hover:bg-brand-500/20 hover:text-brand-500 transition font-medium">Track Order</a>
                @auth
                <a href="{{ route('wishlist') }}" class="block px-6 py-3 text-white hover:bg-brand-500/20 hover:text-brand-500 transition font-medium">Wishlist</a>
                @endauth
            </nav>

            @auth
            <div class="px-6 py-4 border-t border-brand-500/30">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-3 text-center text-red-500 hover:bg-red-500/20 rounded-lg transition font-bold">
                        Logout
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>
</header>

{{-- Spacer to prevent content hiding under fixed header --}}
<div class="h-[112px] md:h-[120px]"></div>
