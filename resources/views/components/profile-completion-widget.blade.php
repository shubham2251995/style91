{{-- Profile Completion Widget --}}
@props(['user'])

@php
    $percentage = $user->profile_completion_percentage;
    $color = $percentage >= 80 ? 'green' : ($percentage >= 50 ? 'yellow' : 'red');
@endphp

<div class="bg-gradient-to-r from-{{ $color }}-500/10 to-brand-accent/10 border border-{{ $color }}-500/30 rounded-xl p-6">
    <div class="flex items-start justify-between mb-4">
        <div>
            <h3 class="font-black text-white text-lg">Profile Strength</h3>
            <p class="text-sm text-gray-400">Complete your profile to unlock rewards</p>
        </div>
        <div class="text-3xl font-black text-{{ $color }}-500">
            {{ $percentage }}%
        </div>
    </div>

    {{-- Progress Bar --}}
    <div class="relative w-full h-3 bg-gray-700 rounded-full overflow-hidden mb-4">
        <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-{{ $color }}-500 to-brand-accent rounded-full transition-all duration-500"
             style="width: {{ $percentage }}%"></div>
    </div>

    {{-- Next Actions --}}
    @if($percentage < 100)
        <div class="space-y-2">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Complete:</p>
            <div class="flex flex-wrap gap-2">
                @if(!$user->avatar)
                    <span class="text-xs bg-gray-700 text-gray-300 px-3 py-1 rounded-full">📸 Add Photo</span>
                @endif
                @if(!$user->bio)
                    <span class="text-xs bg-gray-700 text-gray-300 px-3 py-1 rounded-full">✍️ Add Bio</span>
                @endif
                @if(!$user->phone)
                    <span class="text-xs bg-gray-700 text-gray-300 px-3 py-1 rounded-full">📱 Add Phone</span>
                @endif
                @if(!$user->style_preferences)
                    <span class="text-xs bg-gray-700 text-gray-300 px-3 py-1 rounded-full">👕 Style Prefs</span>
                @endif
                @if(!$user->size_preferences)
                    <span class="text-xs bg-gray-700 text-gray-300 px-3 py-1 rounded-full">📏 Sizes</span>
                @endif
            </div>
        </div>

        {{-- Reward Preview --}}
        @if($percentage >= 80 && $percentage < 100)
            <div class="mt-4 p-3 bg-brand-accent/10 border border-brand-accent/30 rounded-lg">
                <p class="text-sm text-brand-accent font-bold">
                    🎁 Complete 100% to unlock 50 bonus loyalty points!
                </p>
            </div>
        @endif
    @else
        <div class="flex items-center gap-2 text-green-400">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="font-bold">Profile Complete! 🎉</span>
        </div>
    @endif
</div>
