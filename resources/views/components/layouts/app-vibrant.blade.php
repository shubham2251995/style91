@php
// Initialize variables with safe defaults
$siteName = config('app.name', 'Style91');
$seoTagsArray = [];
$headerMenu = null;

// Try to load services gracefully
try {
    $seoService = new \App\Services\SeoService();
    $seoTagsArray = $seoService->generateTags($product ?? null);
} catch (\Exception $e) {
    // SEO service unavailable, use defaults
    $seoTagsArray = [];
}

try {
    $headerMenu = \App\Models\Menu::where('location', 'header')->first();
} catch (\Exception $e) {
    // Menu unavailable
    $headerMenu = null;
}

$metaTitle = $seoTagsArray['title'] ?? $siteName;
$metaDescription = $seoTagsArray['description'] ?? 'Premium Streetwear Fashion';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle }}</title>
    
    {{-- Meta Tags --}}
    <meta name="description" content="{{ $metaDescription }}">
    
    {{-- Tailwind CSS CDN for Development --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-500': '#FFD93D',
                        'brand-accent': '#FFD93D',
                        'accent-500': '#6BCF7F',
                        'electric-500': '#00E5FF',
                        'electric-400': '#33EBFF',
                    }
                }
            }
        }
    </script>
    
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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
