<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-white">Config Engine</h2>

    <form wire:submit.prevent="save" class="space-y-6 max-w-2xl">
        <div class="bg-white/5 p-6 rounded-xl border border-white/10 space-y-4">
            <div>
                <label class="block text-sm font-bold text-gray-400 mb-2">Site Name</label>
                <input wire:model="settings.site_name" type="text" class="w-full bg-black border border-white/20 rounded-lg px-4 py-2 text-white">
            </div>

            <div class="flex items-center justify-between">
                <label class="text-sm font-bold text-gray-400">Maintenance Mode</label>
                <input wire:model="settings.maintenance_mode" type="checkbox" class="w-5 h-5 rounded border-gray-300 text-brand-accent focus:ring-brand-accent">
            </div>

            <div class="flex items-center justify-between">
                <label class="text-sm font-bold text-gray-400">Allow Registrations</label>
                <input wire:model="settings.allow_registrations" type="checkbox" class="w-5 h-5 rounded border-gray-300 text-brand-accent focus:ring-brand-accent">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-400 mb-2">Currency</label>
                <select wire:model="settings.currency" class="w-full bg-black border border-white/20 rounded-lg px-4 py-2 text-white">
                    <option value="USD">USD ($)</option>
                    <option value="EUR">EUR (€)</option>
                    <option value="GBP">GBP (£)</option>
                    <option value="JPY">JPY (¥)</option>
                </select>
            </div>
        </div>

        <button type="submit" class="bg-brand-accent text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-600 transition-colors">
            Save Configuration
        </button>
    </form>
</div>
