{{-- 
    ENHANCED DESKTOP NAVIGATION WITH MEGA MENU
    
    This file contains the complete working navigation sections to replace in app.blade.php
    
    INSTRUCTIONS:
    1. Find line 303-337 in app.blade.php (Gender Toggle through end of Navigation)
    2. Replace with the sections below
    3. Keep everything else in the original file intact
--}}

{{-- SECTION 1: Gender Toggle (Desktop) - Replace lines 303-308 --}}
<!-- Gender Toggle (Desktop) -->
<div class="hidden md:flex items-center gap-4 ml-8">
    <a href="{{ route('search', ['gender' => 'Men']) }}" class="text-sm font-bold uppercase tracking-wider {{ request('gender') == 'Men' ? 'text-brand-black border-b-2 border-brand-accent' : 'text-gray-500 hover:text-brand-black' }}">Men</a>
    <span class="text-gray-300">|</span>
    <a href="{{ route('search', ['gender' => 'Women']) }}" class="text-sm font-bold uppercase tracking-wider {{ request('gender') == 'Women' ? 'text-brand-black border-b-2 border-brand-accent' : 'text-gray-500 hover:text-brand-black' }}">Women</a>
</div>

{{-- SECTION 2: Enhanced Desktop Navigation with Mega Menu - Replace lines 310-337 --}}
<!-- Desktop Navigation with Enhanced Mega Menu -->
<nav class="hidden md:flex items-center gap-6">
    @if(isset($headerMenu) && $headerMenu->items->count() > 0)
        @foreach($headerMenu->tree() as $item)
            <div class="relative group" x-data="{ open: false }">
                <a href="{{ $item->link }}" 
                   target="{{ $item->target }}"
                   @mouseenter="open = true"
                   @mouseleave="setTimeout(() => open = false, 100)"
                   class="text-brand-dark hover:text-brand-accent font-bold text-sm uppercase tracking-wide transition-all duration-200 flex items-center gap-1 py-2">
                    {{ $item->title }}
                    @if($item->children->count() > 0)
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 transition-transform" :class="{ 'rotate-180': open }">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5 7.5" />
                        </svg>
                    @endif
                </a>
                
                @if($item->children->count() > 0)
                    <div x-show="open" 
                         x-cloak
                         @mouseenter="open = true"
                         @mouseleave="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute top-full left-1/2 -translate-x-1/2 mt-2 bg-white border border-gray-100 shadow-2xl rounded-xl overflow-hidden z-50 min-w-[300px]">
                        <div class="p-4">
                            <div class="space-y-1">
                                @foreach($item->children as $child)
                                    <a href="{{ $child->link }}" 
                                       target="{{ $child->target }}"
                                       class="group/item flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:text-brand-accent hover:bg-gray-50 rounded-lg transition-all">
                                        <svg class="w-4 h-4 text-gray-400 group-hover/item:text-brand-accent transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                        <span class="font-medium">{{ $child->title }}</span>
                                    </a>
                                @endforeach
                            </div>
                            <div class="pt-2 mt-2 border-t border-gray-100">
                                <a href="{{ $item->link }}" class="flex items-center justify-between px-3 py-2 text-sm font-bold text-brand-accent hover:bg-brand-accent/10 rounded-lg transition">
                                    View All
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
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

{{-- 
    KEY FEATURES IN THIS ENHANCED NAVIGATION:
    
    1. Alpine.js State Management - Uses x-data for menu state
    2. Smooth Transitions - 200ms ease-out animations
    3. Mega Menu Dropdown - Centered below parent with shadow
    4. Icons - Chevron rotation on hover, arrow icons in menu items
    5. Better Hover States - Smooth color and background transitions
    6. "View All" Link - At bottom of each dropdown
    7. Proper Z-Index - z-50 ensures dropdowns appear above content
    8. x-cloak - Prevents flash of unstyled content
    
    STYLING IMPROVEMENTS:
    - Rounded corners on dropdowns (rounded-xl)
    - Shadow-2xl for depth
    - Hover states with bg-gray-50
    - Brand accent colors for active states
    - Proper spacing with gap and padding utilities
--}}
