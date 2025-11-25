<div class="min-h-screen bg-black text-white flex items-center justify-center p-6">
    <div class="w-full max-w-2xl bg-gray-900 border border-white/10 rounded-2xl p-8 shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black tracking-tighter mb-2">Style91 INSTALLER</h1>
            <div class="flex justify-center gap-2">
                @foreach(range(1, 6) as $s)
                    <div class="h-1 w-8 rounded-full {{ $step >= $s ? 'bg-brand-accent' : 'bg-gray-700' }}"></div>
                @endforeach
            </div>
            <p class="text-gray-400 mb-8">System Setup Wizard</p>
        </div>

        @if($step === 1)
            <h2 class="text-xl font-bold mb-4">System Requirements</h2>
            <div class="space-y-4 mb-6">
                <div class="flex items-center justify-between p-3 bg-white/5 rounded border {{ $status['php'] ? 'border-green-500/50' : 'border-red-500/50' }}">
                    <span>PHP Version >= 8.1</span>
                    <span class="{{ $status['php'] ? 'text-green-500' : 'text-red-500' }} font-bold">{{ phpversion() }}</span>
                </div>
                @foreach($requirements['extensions'] as $ext)
                    <div class="flex items-center justify-between p-3 bg-white/5 rounded border {{ $status[$ext] ? 'border-green-500/50' : 'border-red-500/50' }}">
                        <span class="capitalize">{{ $ext }} Extension</span>
                        <span class="{{ $status[$ext] ? 'text-green-500' : 'text-red-500' }} font-bold">{{ $status[$ext] ? 'OK' : 'MISSING' }}</span>
                    </div>
                @endforeach
            </div>
            <button wire:click="nextStep" class="w-full bg-brand-accent py-3 rounded font-bold hover:bg-blue-600">Start Installation</button>
        @endif

        @if($step === 2)
            <h2 class="text-xl font-bold mb-4">Website Settings</h2>
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Application Name</label>
                    <input wire:model="app_name" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Application URL</label>
                    <input wire:model="app_url" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Select Theme</label>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Bewakoof Theme Option -->
                        <label class="cursor-pointer relative">
                            <input type="radio" wire:model="app_theme" value="bewakoof" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-white/10 peer-checked:border-[#FDD835] bg-white/5 hover:bg-white/10 transition-all">
                                <div class="h-20 bg-gray-100 rounded-lg mb-3 relative overflow-hidden">
                                    <div class="absolute top-0 left-0 w-full h-2 bg-[#FDD835]"></div>
                                    <div class="absolute bottom-2 left-2 w-12 h-2 bg-gray-300 rounded"></div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="font-bold">Bewakoof</span>
                                    <div class="w-4 h-4 rounded-full bg-[#FDD835]"></div>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Yellow & Playful</p>
                            </div>
                        </label>

                        <!-- Veirdo Theme Option -->
                        <label class="cursor-pointer relative">
                            <input type="radio" wire:model="app_theme" value="veirdo" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-white/10 peer-checked:border-[#CCFF00] bg-white/5 hover:bg-white/10 transition-all">
                                <div class="h-20 bg-[#121212] rounded-lg mb-3 relative overflow-hidden">
                                    <div class="absolute top-0 left-0 w-full h-2 bg-[#CCFF00]"></div>
                                    <div class="absolute bottom-2 left-2 w-12 h-2 bg-white/20 rounded"></div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="font-bold">Veirdo</span>
                                    <div class="w-4 h-4 rounded-full bg-[#CCFF00]"></div>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Acid & Dark</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <button wire:click="saveAppConfig" class="w-full bg-brand-accent py-3 rounded font-bold hover:bg-blue-600">Save Settings</button>
        @endif

        @if($step === 3)
            <h2 class="text-xl font-bold mb-4">Database Connection</h2>
            @error('db_connection') <span class="text-red-500 text-sm block mb-2">{{ $message }}</span> @enderror
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">DB Host</label>
                    <input wire:model="db_host" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">DB Port</label>
                    <input wire:model="db_port" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">DB Database</label>
                    <input wire:model="db_database" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">DB Username</label>
                    <input wire:model="db_username" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">DB Password</label>
                    <input wire:model="db_password" type="password" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
            </div>
            <div class="bg-blue-500/10 border border-blue-500/30 rounded-lg p-3 mb-4 text-sm">
                <p class="font-bold text-blue-400 mb-1">💡 Hostinger Users:</p>
                <ul class="text-gray-300 space-y-1 text-xs">
                    <li>• DB Host: Use <code class="bg-black/50 px-1 rounded">localhost</code></li>
                    <li>• Create your database in <strong>hPanel → Databases → MySQL</strong></li>
                    <li>• Username format: <code class="bg-black/50 px-1 rounded">uXXXXXXXX_dbname</code></li>
                </ul>
            </div>
            <button wire:click="saveDatabase" class="w-full bg-brand-accent py-3 rounded font-bold hover:bg-blue-600">Connect Database</button>
        @endif

        @if($step === 4)
            <h2 class="text-xl font-bold mb-4">Running Migrations</h2>
            @error('migration') <span class="text-red-500 text-sm block mb-2">{{ $message }}</span> @enderror
            <div class="bg-black p-4 rounded border border-white/10 font-mono text-xs text-green-400 h-48 overflow-y-auto mb-6">
                > Connecting to database... OK<br>
                > Preparing migration table... OK<br>
                > Migrating: 2014_10_12_000000_create_users_table<br>
                > Migrating: 2014_10_12_100000_create_password_reset_tokens_table<br>
                > Migrating: 2019_08_19_000000_create_failed_jobs_table<br>
                > Migrating: 2019_12_14_000001_create_personal_access_tokens_table<br>
                > Migrating: 2025_11_19_203458_create_products_table<br>
                > Seeding: ProductSeeder... OK<br>
                > Ready.
            </div>
            <button wire:click="runMigrations" class="w-full bg-brand-accent py-3 rounded font-bold hover:bg-blue-600">Run Migrations</button>
        @endif

        @if($step === 5)
            <h2 class="text-xl font-bold mb-4">Create Admin Account</h2>
            @error('admin') <span class="text-red-500 text-sm block mb-2">{{ $message }}</span> @enderror
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Admin Name</label>
                    <input wire:model="admin_name" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Admin Email</label>
                    <input wire:model="admin_email" type="email" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Admin Mobile</label>
                    <input wire:model="admin_mobile" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Admin Password</label>
                    <input wire:model="admin_password" type="password" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
            </div>
            <button wire:click="createAdmin" class="w-full bg-brand-accent py-3 rounded font-bold hover:bg-blue-600">Create Admin & Finish</button>
        @endif

        @if($step === 6)
            <div class="text-center py-10">
                <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold mb-2">Installation Complete!</h2>
                <p class="text-gray-400 mb-2">Style91 is ready for launch.</p>
                <p class="text-sm text-green-400 mb-8">✓ You are now logged in as admin</p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-block bg-brand-accent text-white px-8 py-3 rounded-full font-bold hover:bg-blue-600 transition-colors min-w-[200px]">
                        Go to Admin Panel
                    </a>
                    <a href="{{ route('home') }}" class="inline-block bg-white/10 text-white border border-white/20 px-8 py-3 rounded-full font-bold hover:bg-white/20 transition-colors min-w-[200px]">
                        Go to Home Page
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
