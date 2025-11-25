<div class="min-h-screen bg-black text-white p-6 pb-24">
    <div class="max-w-md mx-auto">
        <h1 class="text-3xl font-black tracking-tighter mb-8 text-brand-accent">SYSTEM SETTINGS</h1>

        @if (session()->has('message'))
            <div class="bg-green-500/20 text-green-500 p-3 rounded mb-4 text-sm font-bold">
                {{ session('message') }}
            </div>
        @endif

        <!-- SMS Settings -->
        <div class="bg-gray-900 rounded-xl p-6 border border-white/10 mb-6">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-brand-accent">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                </svg>
                MSG91 Configuration
            </h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Auth Key</label>
                    <input wire:model="settings.msg91_auth_key" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Sender ID</label>
                    <input wire:model="settings.msg91_sender_id" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">OTP Template ID</label>
                    <input wire:model="settings.msg91_otp_template" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <button wire:click="save('sms')" class="w-full bg-white/10 text-white font-bold py-2 rounded hover:bg-white/20 transition-colors">
                    SAVE SMS SETTINGS
                </button>
            </div>
        </div>

        <!-- Email Settings -->
        <div class="bg-gray-900 rounded-xl p-6 border border-white/10">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-brand-accent">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
                Email Configuration (SMTP)
            </h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Mail Host</label>
                    <input wire:model="settings.mail_host" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Port</label>
                        <input wire:model="settings.mail_port" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Encryption</label>
                        <input wire:model="settings.mail_encryption" type="text" placeholder="tls" class="w-full bg-black border border-white/20 rounded p-2">
                    </div>
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Username</label>
                    <input wire:model="settings.mail_username" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Password</label>
                    <input wire:model="settings.mail_password" type="password" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">From Address</label>
                    <input wire:model="settings.mail_from_address" type="text" class="w-full bg-black border border-white/20 rounded p-2">
                </div>
                <button wire:click="save('email')" class="w-full bg-white/10 text-white font-bold py-2 rounded hover:bg-white/20 transition-colors">
                    SAVE EMAIL SETTINGS
                </button>
            </div>
        </div>
    </div>
</div>
