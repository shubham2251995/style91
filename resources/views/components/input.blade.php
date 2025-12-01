{{-- Vibrant Input Component --}}
@props(['label' => '', 'error' => '', 'type' => 'text'])

<div class="w-full">
    @if($label)
        <label {{ $attributes->only('id')->prepend('for-') }} class="block text-xs font-black uppercase tracking-widest text-gray-700 mb-2">
            {{ $label }}
        </label>
    @endif
    
    <input 
        type="{{ $type }}"
        {{ $attributes->merge(['class' => 'w-full border-2 border-gray-200 rounded-lg px-4 py-3 font-medium text-brand-black focus:border-brand-black focus:ring-2 focus:ring-brand-accent/20 outline-none transition-all placeholder:text-gray-400']) }}
    >
    
    @if($error)
        <p class="mt-1 text-xs font-medium text-red-600">{{ $error }}</p>
    @endif
</div>
