<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">🎨 Banner & Drop Manager</h2>
        <button wire:click="create" class="bg-brand-accent text-black font-bold px-6 py-3 rounded-lg hover:opacity-90 transition">
            + NEW DROP
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-900/50 border border-green-500 text-green-200 px-4 py-3 rounded-lg mb-4">
            {{ session('message') }}
        </div>
    @endif

    {{-- Quick Launch Filters --}}
    <div class="flex gap-2 mb-6 overflow-x-auto pb-2">
        <button wire:click="$set('filterType', 'all')" 
                class="px-4 py-2 rounded-lg font-semibold {{ $filterType === 'all' ? 'bg-brand-accent text-black' : 'bg-gray-800 text-white hover:bg-gray-700' }}">
            All
        </button>
        <button wire:click="$set('filterType', 'drop')" 
                class="px-4 py-2 rounded-lg font-semibold {{ $filterType === 'drop' ? 'bg-brand-accent text-black' : 'bg-gray-800 text-white hover:bg-gray-700' }}">
            🚀 Drop Hero
        </button>
        <button wire:click="$set('filterType', 'story')" 
                class="px-4 py-2 rounded-lg font-semibold {{ $filterType === 'story' ? 'bg-brand-accent text-black' : 'bg-gray-800 text-white hover:bg-gray-700' }}">
            📱 Story
        </button>
        <button wire:click="$set('filterType', 'community')" 
                class="px-4 py-2 rounded-lg font-semibold {{ $filterType === 'community' ? 'bg-brand-accent text-black' : 'bg-gray-800 text-white hover:bg-gray-700' }}">
            👥 Community
        </button>
        <button wire:click="$set('filterType', 'hype')" 
                class="px-4 py-2 rounded-lg font-semibold {{ $filterType === 'hype' ? 'bg-brand-accent text-black' : 'bg-gray-800 text-white hover:bg-gray-700' }}">
            🚂 Hype Train
        </button>
        <button wire:click="$set('filterType', 'collab')" 
                class="px-4 py-2 rounded-lg font-semibold {{ $filterType === 'collab' ? 'bg-brand-accent text-black' : 'bg-gray-800 text-white hover:bg-gray-700' }}">
            🤝 Collab
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Banner List --}}
        <div class="lg:col-span-2 space-y-4">
            @forelse($banners as $banner)
                <div class="bg-gray-800 p-4 rounded-xl border border-gray-700 flex items-center gap-4">
                    {{-- Thumbnail --}}
                    <div class="w-20 h-20 bg-gray-700 rounded overflow-hidden flex-shrink-0">
                        @if($banner->desktop_media_url)
                            @if($banner->media_type === 'video')
                                <video src="{{ $banner->desktop_media_url }}" class="w-full h-full object-cover" muted></video>
                            @else
                                <img src="{{ $banner->desktop_media_url }}" class="w-full h-full object-cover">
                            @endif
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-bold text-lg">{{ $banner->title }}</h4>
                            <span class="text-xs bg-gray-700 px-2 py-0.5 rounded uppercase">
                                {{ $banner->type }}
                            </span>
                            @if($banner->media_type === 'video')
                                <span class="text-xs bg-purple-600 px-2 py-0.5 rounded">VIDEO</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-400 truncate">{{ $banner->subtitle }}</p>
                        
                        @if($banner->type === 'drop' && $banner->drop_date)
                            <pclass="text-xs text-gray-500 mt-1">
                                🕒 {{ $banner->drop_date->format('M d, Y h:i A') }}
                                @if($banner->notify_enabled)
                                    · <span class="text-brand-accent">{{ $banner->notification_count }} notifications</span>
                                @endif
                            </p>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2">
                        <button wire:click="toggleActive({{ $banner->id }})" class="p-2 rounded {{ $banner->is_active ? 'text-green-400 bg-green-900/30' : 'text-gray-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                            </svg>
                        </button>
                        <button wire:click="edit({{ $banner->id }})" class="p-2 rounded text-blue-400 hover:bg-blue-900/30">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </button>
                        <button wire:click="delete({{ $banner->id }})" onclick="return confirm('Delete this banner?')" class="p-2 rounded text-red-400 hover:bg-red-900/30">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="bg-gray-800 p-8 rounded-xl border border-gray-700 text-center text-gray-400">
                    No banners found. Create your first banner!
                </div>
            @endforelse
        </div>

        {{-- Form --}}
        <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 h-fit sticky top-6">
            <h3 class="text-xl font-bold mb-4 text-brand-accent">
                {{ $editingBannerId ? 'Edit Banner' : 'Create Banner' }}
            </h3>
            
            <div class="space-y-4 max-h-[calc(100vh-200px)] overflow-y-auto pr-2">
                {{-- Banner Type --}}
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Banner Type</label>
                    <select wire:model="type" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white">
                        <option value="drop">🚀 Drop Hero</option>
                        <option value="story">📱 Story Banner</option>
                        <option value="community">👥 Community</option>
                        <option value="hype">🚂 Hype Train</option>
                        <option value="collab">🤝 Collab</option>
                        <option value="standard">Standard Banner</option>
                    </select>
                </div>

                {{-- Title & Subtitle --}}
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Title *</label>
                    <input type="text" wire:model="title" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Subtitle</label>
                    <input type="text" wire:model="subtitle" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white">
                </div>

                {{-- Media Type --}}
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Media Type</label>
                    <select wire:model="media_type" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white">
                        <option value="image">Image</option>
                        <option value="video">Video</option>
                        <option value="gif">GIF</option>
                    </select>
                </div>

                {{-- Media Uploads --}}
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Desktop Media</label>
                    @if($desktop_media)
                        <div class="mb-2 p-2 bg-gray-900 rounded border border-gray-600">
                            <p class="text-xs text-green-400">✓ File selected: {{ $desktop_media->getClientOriginalName() }}</p>
                        </div>
                    @elseif($desktop_media_url)
                        <div class="mb-2">
                            @if($media_type === 'video')
                                <video src="{{ $desktop_media_url }}" class="w-full h-32 object-cover rounded" controls></video>
                            @else
                                <img src="{{ $desktop_media_url }}" class="w-full h-32 object-cover rounded">
                            @endif
                        </div>
                    @endif
                    <input type="file" wire:model="desktop_media" accept="{{ $media_type === 'video' ? 'video/*' : 'image/*' }}" class="text-sm text-gray-400 w-full">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Mobile Media (Optional)</label>
                    @if($mobile_media)
                        <div class="mb-2 p-2 bg-gray-900 rounded border border-gray-600">
                            <p class="text-xs text-green-400">✓ File selected: {{ $mobile_media->getClientOriginalName() }}</p>
                        </div>
                    @elseif($mobile_media_url)
                        <div class="mb-2">
                            @if($media_type === 'video')
                                <video src="{{ $mobile_media_url }}" class="w-full h-32 object-cover rounded" controls></video>
                            @else
                                <img src="{{ $mobile_media_url }}" class="w-full h-32 object-cover rounded">
                            @endif
                        </div>
                    @endif
                    <input type="file" wire:model="mobile_media" accept="{{ $media_type === 'video' ? 'video/*' : 'image/*' }}" class="text-sm text-gray-400 w-full">
                </div>

                {{-- Drop Settings --}}
                @if($type === 'drop')
                    <div class="border-t border-gray-700 pt-4">
                        <h4 class="font-bold text-sm text-brand-accent mb-3">DROP SETTINGS</h4>
                        
                        <div class="mb-3">
                            <label class="block text-sm text-gray-400 mb-1">Drop Date & Time</label>
                            <input type="datetime-local" wire:model="drop_date" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white text-sm">
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm text-gray-400 mb-1">Stock Count</label>
                            <input type="number" wire:model="stock_count" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white">
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" wire:model="notify_enabled" id="notify_enabled" class="rounded bg-gray-900 border-gray-600 text-brand-accent">
                            <label for="notify_enabled" class="text-sm text-gray-300">Enable "Notify Me"</label>
                        </div>
                    </div>
                @endif

                {{-- CTA --}}
                <div class="border-t border-gray-700 pt-4">
                    <h4 class="font-bold text-sm text-gray-300 mb-3">CALL TO ACTION</h4>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">CTA Text</label>
                            <input type="text" wire:model="cta_text" placeholder="SHOP NOW" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white text-sm">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">CTA URL</label>
                            <input type="text" wire:model="cta_url" placeholder="/shop" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white text-sm">
                        </div>
                    </div>
                </div>

                {{-- Styling --}}
                <div class="border-t border-gray-700 pt-4">
                    <h4 class="font-bold text-sm text-gray-300 mb-3">STYLING</h4>
                    
                    <div class="mb-3">
                        <label class="block text-sm text-gray-400 mb-1">Overlay Type</label>
                        <select wire:model="overlay_type" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white text-sm">
                            <option value="gradient">Gradient</option>
                            <option value="solid">Solid</option>
                            <option value="glitch">Glitch</option>
                            <option value="grain">Grain/VHS</option>
                            <option value="none">None</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm text-gray-400 mb-1">Overlay Opacity: {{ $overlay_opacity }}%</label>
                        <input type="range" wire:model="overlay_opacity" min="0" max="100" class="w-full">
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm text-gray-400 mb-1">Text Position</label>
                        <select wire:model="text_position" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white text-sm">
                            <option value="center">Center</option>
                            <option value="left">Left</option>
                            <option value="right">Right</option>
                            <option value="bottom-left">Bottom Left</option>
                            <option value="bottom-center">Bottom Center</option>
                            <option value ="bottom-right">Bottom Right</option>
                        </select>
                    </div>
                </div>

                {{-- Position & Visibility --}}
                <div class="border-t border-gray-700 pt-4">
                    <h4 class="font-bold text-sm text-gray-300 mb-3">VISIBILITY</h4>
                    
                    <div class="mb-3">
                        <label class="block text-sm text-gray-400 mb-1">Position</label>
                        <select wire:model="position" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white text-sm">
                            <option value="hero">Hero (Top)</option>
                            <option value="header-sticky">Header Sticky</option>
                            <option value="between-sections">Between Sections</option>
                            <option value="footer">Footer</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm text-gray-400 mb-1">Priority</label>
                        <input type="number" wire:model="display_priority" class="w-full bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white text-sm">
                    </div>

                    <div class="flex items-center gap-2 mb-3">
                        <input type="checkbox" wire:model="is_active" id="is_active" class="rounded bg-gray-900 border-gray-600 text-brand-accent">
                        <label for="is_active" class="text-sm text-gray-300">Active</label>
                    </div>
                </div>

                {{-- Save Buttons --}}
                <div class="pt-4 border-t border-gray-700 space-y-2">
                    <button wire:click="save" class="w-full bg-brand-accent text-black font-bold py-3 rounded-lg hover:opacity-90 transition">
                        {{ $editingBannerId ? 'UPDATE BANNER' : 'CREATE BANNER' }}
                    </button>
                    
                    @if($editingBannerId)
                        <button wire:click="resetForm" class="w-full bg-gray-700 text-white font-bold py-2 rounded-lg hover:bg-gray-600 transition">
                            Cancel
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
