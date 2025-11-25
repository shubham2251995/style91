@props(['class' => '', 'count' => 1])

<div {{ $attributes->merge(['class' => 'animate-pulse ' . $class]) }}>
    @for ($i = 0; $i < $count; $i++)
        <div class="bg-gray-200 rounded h-full w-full mb-2 last:mb-0"></div>
    @endfor
</div>
