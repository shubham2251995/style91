{{-- Loyalty Points Badge --}}
@props(['user'])

<div class="flex items-center gap-3 bg-gradient-to-r from-yellow-500/10 to-brand-accent/10 border border-yellow-500/30 rounded-xl px-4 py-3">
    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600">
        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
        </svg>
    </div>
    <div>
        <div class="text-2xl font-black text-white">{{ number_format($user->loyalty_points) }}</div>
        <div class="text-xs text-gray-400 uppercase tracking-wide">Loyalty Points</div>
    </div>
</div>
