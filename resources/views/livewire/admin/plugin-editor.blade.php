<div>
    @if($errorMessage)
        <div class="mb-4 bg-red-500/10 border border-red-500/50 rounded-xl p-4 text-red-400">
            {{ $errorMessage }}
        </div>
    @endif
    @if($successMessage)
        <div class="mb-4 bg-green-500/10 border border-green-500/50 rounded-xl p-4 text-green-400">
            {{ $successMessage }}
        </div>
    @endif

    <h2 class="text-2xl font-bold mb-4">Edit Plugin Configuration: {{ $pluginKey }}</h2>

    <form wire:submit.prevent="save">
        @foreach($config as $key => $value)
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-1" for="config-{{ $key }}">{{ $key }}</label>
                <input type="text" id="config-{{ $key }}" wire:model.defer="config.{{ $key }}"
                       class="w-full bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-brand-accent" />
            </div>
        @endforeach
        <button type="submit" class="px-4 py-2 bg-brand-accent text-black font-bold rounded hover:scale-105 transition-transform">
            Save Configuration
        </button>
    </form>
</div>
