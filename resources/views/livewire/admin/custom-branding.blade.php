<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-white">Custom Branding</h2>

    <form wire:submit.prevent="save" class="space-y-8 max-w-xl">
        <!-- Logo Upload -->
        <div class="bg-white/5 p-6 rounded-xl border border-white/10">
            <label class="block text-sm font-bold text-gray-400 mb-4">Brand Logo</label>
            
            <div class="flex items-center gap-6">
                @if($currentLogo)
                    <div class="w-20 h-20 bg-black rounded-lg border border-white/20 flex items-center justify-center p-2">
                        <img src="{{ $currentLogo }}" class="max-w-full max-h-full">
                    </div>
                @endif

                <div class="flex-1">
                    <input type="file" wire:model="logo" class="text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-accent file:text-white hover:file:bg-blue-600">
                </div>
            </div>
        </div>

        <!-- Color Picker -->
        <div class="bg-white/5 p-6 rounded-xl border border-white/10">
            <label class="block text-sm font-bold text-gray-400 mb-4">Primary Accent Color</label>
            <div class="flex items-center gap-4">
                <input type="color" wire:model="primaryColor" class="h-12 w-24 bg-transparent border-0 rounded cursor-pointer">
                <span class="font-mono text-white">{{ $primaryColor }}</span>
            </div>
        </div>

        <button type="submit" class="bg-white text-black font-bold py-3 px-8 rounded-lg hover:bg-gray-200 transition-colors">
            Save Changes
        </button>
    </form>
</div>
