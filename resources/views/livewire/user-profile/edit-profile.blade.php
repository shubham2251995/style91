<div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-bold text-lg mb-4">Edit Profile</h3>
        
        <form wire:submit.prevent="save">
            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input 
                    type="text" 
                    id="name" 
                    wire:model="name" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-accent focus:border-brand-accent"
                >
                @error('name') 
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input 
                    type="tel" 
                    id="phone" 
                    wire:model="phone" 
                    placeholder="+91-XXXXXXXXXX"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-accent focus:border-brand-accent"
                >
                @error('phone') 
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Bio -->
            <div class="mb-6">
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                <textarea 
                    id="bio" 
                    wire:model="bio"
                    rows="4" 
                    placeholder="Tell us about yourself..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-accent focus:border-brand-accent resize-none"
                ></textarea>
                <div class="text-sm text-gray-500 mt-1">{{ strlen($bio ?? '') }}/500</div>
                @error('bio') 
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Save Button -->
            <button 
                type="submit"
                wire:loading.attr="disabled"
                class="w-full bg-brand-black text-white px-6 py-3 rounded-lg font-bold text-sm uppercase tracking-wider hover:bg-gray-800 transition-colors disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="save">Save Changes</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>

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
