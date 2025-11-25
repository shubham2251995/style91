<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100" wire:poll.10s="checkHealth">
    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-brand-accent">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
        </svg>
        System Health
    </h3>

    <div class="grid grid-cols-3 gap-4">
        <!-- Database -->
        <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Database</p>
            <div class="flex items-center justify-center gap-1">
                <span class="w-2 h-2 rounded-full {{ $dbStatus === 'online' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                <span class="font-bold {{ $dbStatus === 'online' ? 'text-green-600' : 'text-red-600' }}">
                    {{ strtoupper($dbStatus) }}
                </span>
            </div>
        </div>

        <!-- Cache -->
        <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Cache</p>
            <div class="flex items-center justify-center gap-1">
                <span class="w-2 h-2 rounded-full {{ $cacheStatus === 'online' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                <span class="font-bold {{ $cacheStatus === 'online' ? 'text-green-600' : 'text-red-600' }}">
                    {{ strtoupper($cacheStatus) }}
                </span>
            </div>
        </div>

        <!-- Queue -->
        <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Queue</p>
            <p class="font-bold text-gray-900">{{ $queueSize }} Jobs</p>
        </div>
    </div>
</div>
