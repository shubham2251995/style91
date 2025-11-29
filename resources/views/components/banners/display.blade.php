@props(['position' => 'hero'])

@php
$banners = \App\Models\Banner::active()
    ->position($position)
    ->ordered()
    ->get();
@endphp

@foreach($banners as $banner)
    @if($banner->isCurrentlyVisible())
        {{-- Render appropriate banner component based on type --}}
        @switch($banner->type)
            @case('drop')
                <x-banners.drop-hero :banner="$banner" />
                @break
            
            @case('community')
                <x-banners.community-hero :banner="$banner" />
                @break
            
            @case('hype')
                <x-banners.hype-banner :banner="$banner" />
                @break
            
            @default
                <x-banners.standard-banner :banner="$banner" />
        @endswitch
    @endif
@endforeach
