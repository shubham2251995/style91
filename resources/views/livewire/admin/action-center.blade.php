<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-white">Action Center</h2>

    <div class="space-y-4 max-w-3xl">
        <!-- Critical Alert -->
        <div class="bg-red-500/10 border border-red-500/20 p-4 rounded-xl flex gap-4 items-start">
            <div class="bg-red-500 p-2 rounded-lg text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-white">Database Backup Failed</h3>
                <p class="text-sm text-gray-400">The automated backup scheduled for 03:00 AM failed due to storage limits.</p>
                <div class="mt-3 flex gap-3">
                    <button class="text-xs font-bold bg-red-500 text-white px-3 py-1.5 rounded hover:bg-red-600">Retry Backup</button>
                    <button class="text-xs font-bold bg-white/10 text-white px-3 py-1.5 rounded hover:bg-white/20">Dismiss</button>
                </div>
            </div>
            <span class="text-xs text-gray-500">2h ago</span>
        </div>

        <!-- Warning -->
        <div class="bg-yellow-500/10 border border-yellow-500/20 p-4 rounded-xl flex gap-4 items-start">
            <div class="bg-yellow-500 p-2 rounded-lg text-black">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-white">High Latency Detected</h3>
                <p class="text-sm text-gray-400">Response times in the US-East region are higher than normal (>500ms).</p>
            </div>
            <span class="text-xs text-gray-500">15m ago</span>
        </div>

        <!-- Info -->
        <div class="bg-blue-500/10 border border-blue-500/20 p-4 rounded-xl flex gap-4 items-start">
            <div class="bg-blue-500 p-2 rounded-lg text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-white">New User Milestone</h3>
                <p class="text-sm text-gray-400">You just crossed 1,000 registered users! 🎉</p>
            </div>
            <span class="text-xs text-gray-500">1d ago</span>
        </div>
    </div>
</div>
