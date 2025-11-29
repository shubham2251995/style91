<div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-bold text-lg mb-4">Profile Photo</h3>
        
        <!-- Current Photo -->
        <div class="flex items-center gap-6 mb-6">
            <div class="relative">
                @if(Auth::user()->profile_photo_url)
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile Photo" class="w-24 h-24 rounded-full object-cover border-4 border-gray-200">
                @else
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-brand-accent to-yellow-400 flex items-center justify-center text-brand-black font-black text-3xl border-4 border-gray-200">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            
            <div class="flex-1">
                <h4 class="font-bold text-gray-900">{{ Auth::user()->name }}</h4>
                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <!-- Upload Form -->
        <form wire:submit.prevent="save">
            <div class="mb-4">
                <label class="block">
                    <span class="sr-only">Choose profile photo</span>
                    <input 
                        type="file" 
                        wire:model="photo" 
                        accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-accent file:text-brand-black hover:file:bg-yellow-400 transition-all"
                    >
                </label>
                
                @error('photo') 
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                @enderror
            </div>

            @if ($photo)
                <!-- Preview -->
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Preview:</p>
                    <img src="{{ $photo->temporaryUrl() }}" class="w-32 h-32 rounded-full object-cover border-2 border-brand-accent">
                </div>

                <!-- Upload Button -->
                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    class="bg-brand-black text-white px-6 py-2 rounded-lg font-bold text-sm uppercase tracking-wider hover:bg-gray-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span wire:loading.remove wire:target="save">Upload Photo</span>
                    <span wire:loading wire:target="save">Uploading...</span>
                </button>
            @endif

            @if (session()->has('message'))
                <div class="mt-4 p-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mt-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm">
                    {{ session('error') }}
                </div>
            @endif
        </form>
    </div>
</div>
