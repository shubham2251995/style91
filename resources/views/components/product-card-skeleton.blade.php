@props(['product'])

{{-- Skeleton Loading State for Product Card --}}
<div class="group relative animate-pulse">
    {{-- Image Skeleton --}}
    <div class="aspect-[3/4] bg-gray-200 mb-3 rounded-sm">
        <div class="w-full h-full flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
    </div>
    
    {{-- Info Skeleton --}}
    <div class="space-y-2">
        {{-- Rating --}}
        <div class="flex gap-1">
            <div class="w-4 h-4 bg-gray-200 rounded"></div>
            <div class="w-4 h-4 bg-gray-200 rounded"></div>
            <div class="w-4 h-4 bg-gray-200 rounded"></div>
            <div class="w-4 h-4 bg-gray-200 rounded"></div>
            <div class="w-4 h-4 bg-gray-200 rounded"></div>
        </div>
        
        {{-- Title --}}
        <div class="h-4 bg-gray-200 rounded w-3/4"></div>
        <div class="h-4 bg-gray-200 rounded w-1/2"></div>
        
        {{-- Size Badges --}}
        <div class="flex gap-1">
            <div class="h-5 w-8 bg-gray-200 rounded"></div>
            <div class="h-5 w-8 bg-gray-200 rounded"></div>
            <div class="h-5 w-8 bg-gray-200 rounded"></div>
            <div class="h-5 w-8 bg-gray-200 rounded"></div>
        </div>
        
        {{-- Price --}}
        <div class="h-6 bg-gray-200 rounded w-1/3"></div>
    </div>
</div>
