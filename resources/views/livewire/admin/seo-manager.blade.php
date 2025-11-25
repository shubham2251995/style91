<div class="min-h-screen bg-black text-white p-6 pb-24">
    <div class="max-w-md mx-auto">
        <h1 class="text-3xl font-black tracking-tighter mb-8 text-brand-accent">SEO MASTER</h1>

        <div class="bg-gray-900 rounded-xl p-6 border border-white/10 mb-6">
            <h2 class="text-xl font-bold mb-4">Global Settings</h2>
            
            @if (session()->has('message'))
                <div class="bg-green-500/20 text-green-500 p-3 rounded mb-4 text-sm font-bold">
                    {{ session('message') }}
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Site Title</label>
                    <input wire:model="globalTitle" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Default Description</label>
                    <textarea wire:model="globalDescription" rows="3" class="w-full bg-black border border-white/20 rounded p-2"></textarea>
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Keywords</label>
                    <input wire:model="globalKeywords" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
            </div>
            
            <button wire:click="save" class="w-full bg-brand-accent text-black font-bold py-3 rounded mt-6 hover:bg-white transition-colors">
                SAVE CHANGES
            </button>
        </div>

        <div class="bg-gray-900 rounded-xl p-6 border border-white/10">
            <h2 class="text-xl font-bold mb-4">Tools</h2>
            <div class="space-y-2">
                <a href="{{ url('/sitemap.xml') }}" target="_blank" class="flex items-center justify-between p-3 bg-black rounded hover:bg-white/5 transition-colors">
                    <span>View Sitemap.xml</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </a>
                <div class="flex items-center justify-between p-3 bg-black rounded opacity-50 cursor-not-allowed">
                    <span>Generate Robots.txt</span>
                    <span class="text-xs bg-white/10 px-2 py-1 rounded">Coming Soon</span>
                </div>
            </div>
        </div>
    </div>
</div>
