{{-- Clean Modern Header - Bewakoof.com Inspired --}}
<header class="sticky top-0 left-0 w-full z-50 bg-white shadow-sm" x-data="{ mobileMenuOpen: false, searchOpen: false }">
    
    {{-- Top Promo Bar --}}
    <div class="bg-gray-900 text-white py-2 px-4 text-center text-sm font-medium">
        <div class="flex items-center justify-center gap-2">
            <span>🔥 MEGA SALE: Get 50% OFF + Free Shipping on Orders Above ₹999!</span>
        </div>
    </div>

    {{-- Main Header --}}
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">
                
                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = true" class="md:hidden text-gray-700 hover:text-black p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="text-2xl md:text-3xl font-black tracking-tight text-black">
                        STYLE<span class="text-yellow-400">91</span>
                    </div>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('new-arrivals') }}" class="text-gray-700 hover:text-black font-medium text-sm transition-colors">Men</a>
                    <a href="{{ route('search') }}" class="text-gray-700 hover:text-black font-medium text-sm transition-colors">Women</a>
                    <a href="{{ route('search') }}" class="text-gray-700 hover:text-black font-medium text-sm transition-colors">Mobile Covers</a>
                    <a href="{{ route('sale') }}" class="text-red-600 hover:text-red-700 font-bold text-sm transition-colors">SALE</a>
                </nav>

                {{-- Action Icons --}}
                <div class="flex items-center gap-4 md:gap-6">
                    {{-- Search --}}
                    <button @click="searchOpen = !searchOpen" class="text-gray-700 hover:text-black transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>

                    {{-- Wishlist --}}
                    @auth
                    <a href="{{ route('wishlist') }}" class="relative text-gray-700 hover:text-black transition-colors hidden md:block">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </a>
                    @endauth

                    {{-- Cart --}}
                    <button @click="$dispatch('open-cart')" class="relative text-gray-700 hover:text-black transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="absolute -top-2 -right-2 w-5 h-5 bg-yellow-400 text-black text-xs font-bold rounded-full flex items-center justify-center">@livewire('cart-count')</span>
                    </button>

                    {{-- Account --}}
                    @auth
                    <a href="{{ route('profile') }}" class="hidden md:flex items-center gap-2 text-gray-700 hover:text-black font-medium text-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="hidden lg:inline">{{ auth()->user()->name }}</span>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="hidden md:block bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- Search Overlay --}}
    <div x-show="searchOpen" 
         x-transition
         @click.away="searchOpen = false"
         class="absolute top-full left-0 w-full bg-white border-b border-gray-200 py-4 px-4 shadow-lg">
        <div class="max-w-7xl mx-auto">
            <input type="text" 
                   placeholder="Search for products, brands, categories..."
                   class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-black focus:ring-1 focus:ring-black transition-all">
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" 
         x-transition
         @click="mobileMenuOpen = false"
         class="fixed inset-0 bg-black/50 z-50 md:hidden">
        <div @click.stop class="w-80 h-full bg-white shadow-xl overflow-y-auto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0">
            
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-2xl font-black">STYLE<span class="text-yellow-400">91</span></span>
                    <button @click="mobileMenuOpen = false" class="text-gray-500 hover:text-black">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                @auth
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-black font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-black font-bold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="block text-center bg-black text-white px-4 py-2 rounded-lg font-medium">Login / Sign Up</a>
                @endauth
            </div>

            <nav class="py-4">
                <a href="{{ route('new-arrivals') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-black transition font-medium">Men</a>
                <a href="{{ route('search') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-black transition font-medium">Women</a>
                <a href="{{ route('search') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-black transition font-medium">Mobile Covers</a>
                <a href="{{ route('sale') }}" class="block px-6 py-3 text-red-600 hover:bg-red-50 transition font-bold">🔥 SALE</a>
                @auth
                <a href="{{ route('wishlist') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-black transition font-medium">Wishlist</a>
                @endauth
            </nav>

            @auth
            <div class="px-6 py-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-3 text-center text-red-600 hover:bg-red-50 rounded-lg transition font-bold">
                        Logout
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>
</header>
