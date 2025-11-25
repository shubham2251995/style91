<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Site Settings</h1>
        <button wire:click="save" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Save All Settings
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabs --}}
    <div class="border-b border-gray-200 mb-6">
        <nav class="flex space-x-4">
            <button wire:click="setActiveTab('branding')" 
                class="px-4 py-2 border-b-2 {{ $activeTab === 'branding' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Branding
            </button>
            <button wire:click="setActiveTab('contact')" 
                class="px-4 py-2 border-b-2 {{ $activeTab === 'contact' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Contact
            </button>
            <button wire:click="setActiveTab('social')" 
                class="px-4 py-2 border-b-2 {{ $activeTab === 'social' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Social Media
            </button>
            <button wire:click="setActiveTab('seo')" 
                class="px-4 py-2 border-b-2 {{ $activeTab === 'seo' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                SEO
            </button>
            <button wire:click="setActiveTab('content')" 
                class="px-4 py-2 border-b-2 {{ $activeTab === 'content' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Content
            </button>
        </nav>
    </div>

    {{-- Tab Content --}}
    <div class="bg-white rounded-lg shadow p-6">
        @if($activeTab === 'branding')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                    <input type="text" wire:model="site_name" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Site Tagline</label>
                    <input type="text" wire:model="site_tagline" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo URL</label>
                    <input type="url" wire:model="logo_url" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="https://...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Favicon URL</label>
                    <input type="url" wire:model="favicon_url" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="https://...">
                </div>
            </div>
        @endif

        @if($activeTab === 'contact')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
                    <input type="email" wire:model="contact_email" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
                    <input type="text" wire:model="contact_phone" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Address</label>
                    <textarea wire:model="contact_address" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2"></textarea>
                </div>
            </div>
        @endif

        @if($activeTab === 'social')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                    <input type="url" wire:model="facebook_url" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="https://facebook.com/...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                    <input type="url" wire:model="instagram_url" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="https://instagram.com/...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Twitter URL</label>
                    <input type="url" wire:model="twitter_url" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="https://twitter.com/...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">YouTube URL</label>
                    <input type="url" wire:model="youtube_url" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="https://youtube.com/...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">TikTok URL</label>
                    <input type="url" wire:model="tiktok_url" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="https://tiktok.com/@...">
                </div>
            </div>
        @endif

        @if($activeTab === 'seo')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                    <input type="text" wire:model="meta_title" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                    <textarea wire:model="meta_description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                    <input type="text" wire:model="meta_keywords" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="keyword1, keyword2, keyword3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">OG Image URL</label>
                    <input type="url" wire:model="og_image" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="https://...">
                </div>
            </div>
        @endif

        @if($activeTab === 'content')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Footer Text</label>
                    <input type="text" wire:model="footer_text" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Welcome Message</label>
                    <input type="text" wire:model="welcome_message" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
            </div>
        @endif
    </div>
</div>
