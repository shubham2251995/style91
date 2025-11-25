<div class="max-w-2xl mx-auto p-6">
    <div class="bg-black/40 backdrop-blur-md border border-white/10 rounded-xl p-8">
        <h2 class="text-3xl font-bold mb-6 text-white tracking-tighter">UPLOAD YOUR FIT</h2>

        <form wire:submit.prevent="save" class="space-y-6">
            <!-- Image Upload Area -->
            <div class="relative group">
                <div class="border-2 border-dashed border-white/20 rounded-lg p-8 text-center transition-all duration-300 hover:border-purple-500 hover:bg-white/5">
                    @if ($photo)
                        <div class="relative">
                            <img src="{{ $photo->temporaryUrl() }}" class="max-h-96 mx-auto rounded-lg shadow-2xl">
                            <button type="button" wire:click="$set('photo', null)" class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    @else
                        <div class="space-y-4">
                            <div class="mx-auto w-16 h-16 bg-white/10 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 group-hover:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="text-gray-400">
                                <span class="text-purple-400 font-medium">Click to upload</span> or drag and drop
                                <p class="text-sm mt-1">PNG, JPG up to 10MB</p>
                            </div>
                        </div>
                        <input type="file" wire:model="photo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    @endif
                </div>
                @error('photo') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
            </div>

            <!-- Caption -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">CAPTION</label>
                <textarea wire:model="caption" rows="3" class="w-full bg-black/50 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all" placeholder="Describe your fit..."></textarea>
                @error('caption') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-white text-black font-bold py-4 rounded-lg hover:bg-gray-200 transition-all duration-300 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed" wire:loading.attr="disabled">
                <span wire:loading.remove>SHARE FIT</span>
                <span wire:loading>UPLOADING...</span>
            </button>
        </form>
    </div>
</div>
