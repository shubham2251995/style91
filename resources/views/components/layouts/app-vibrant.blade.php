<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Style91 - Youth Fashion' }}</title>
    
    
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-black text-white antialiased" x-data="{ mobileMenuOpen: false, searchOpen: false }">
    
    {{-- Global Lazy Loader --}}
    <div wire:loading class="fixed top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-accent-500 z-[100] animate-pulse"></div>

    {{-- Vibrant Header --}}
    @include('components.header-vibrant')

    {{-- Main Content --}}
    <main class="min-h-screen pt-[104px] md:pt-[120px] pb-16 px-4 md:px-6 lg:px-8">
        {{ $slot }}
    </main>

    {{-- Vibrant Footer --}}
    @include('components.footer-vibrant')

    @livewireScripts
    
    {{-- Cart Drawer --}}
    <livewire:cart-drawer />

    {{-- Quick View Modal --}}
    <livewire:quick-view />
    
    {{-- Quick View Event Listener --}}
    <script>
        window.addEventListener('quick-view', event => {
            const productId = event.detail.productId;
            if (productId) {
                Livewire.dispatch('openQuickView', { productId: productId });
            }
        });
    </script>
</body>
</html>
