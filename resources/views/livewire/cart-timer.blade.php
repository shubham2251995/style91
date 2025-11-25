<div wire:poll.1s="checkTimer">
    @if($isActive && $timeLeft > 0)
        <div class="fixed top-0 left-0 w-full bg-brand-accent text-white text-center py-1 z-50 font-mono text-xs font-bold tracking-widest uppercase">
            Cart Reserved: {{ gmdate('i:s', $timeLeft) }}
        </div>
    @endif
</div>
