<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Payment Gateway Settings</h2>
            <button wire:click="createDefaultGateways" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Initialize Gateways
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Payment Gateways List -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($gateways as $gateway)
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-bold">{{ $gateway->name }}</h3>
                            <p class="text-sm text-gray-600">Code: {{ $gateway->code }}</p>
                        </div>
                        <button wire:click="toggleStatus({{ $gateway->id }})" class="px-3 py-1 text-xs rounded-full {{ $gateway->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $gateway->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </div>

                    <p class="text-sm text-gray-600 mb-4">{{ $gateway->description }}</p>

                    <!-- Gateway Info -->
                    <div class="space-y-2 text-sm mb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Min Order:</span>
                            <span class="font-medium">₹{{ $gateway->rules['min_order_value'] ?? 0 }}</span>
                        </div>
                        @if(isset($gateway->rules['max_order_value']))
                            <div class="flex justify-between">
                                <span class="text-gray-600">Max Order:</span>
                                <span class="font-medium">₹{{ number_format($gateway->rules['max_order_value']) }}</span>
                            </div>
                        @endif
                        @if($gateway->code === 'cod' && isset($gateway->rules['cod_charges']))
                            <div class="flex justify-between">
                                <span class="text-gray-600">COD Charges:</span>
                                <span class="font-medium">₹{{ $gateway->rules['cod_charges'] }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Mode:</span>
                            <span class="font-medium">{{ $gateway->is_test_mode ? 'Test' : 'Live' }}</span>
                        </div>
                    </div>

                    <button wire:click="editGateway({{ $gateway->id }})" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Configure
                    </button>
                </div>
            @endforeach
        </div>

        <!-- Configuration Modal -->
        @if($isModalOpen)
        <div class="fixed z-50 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <h3 class="text-lg font-bold mb-4">Configure {{ $name }}</h3>
                        
                        <div class="space-y-4">
                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea wire:model="description" rows="2" class="w-full border-gray-300 rounded-lg"></textarea>
                            </div>

                            <!-- Razorpay Config -->
                            @if($code === 'razorpay')
                                <div class="bg-blue-50 p-4 rounded-lg space-y-3">
                                    <h4 class="font-bold text-sm">Razorpay Credentials</h4>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">API Key</label>
                                        <input type="text" wire:model="apiKey" class="w-full border-gray-300 rounded-lg" placeholder="rzp_test_...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">API Secret</label>
                                        <input type="password" wire:model="apiSecret" class="w-full border-gray-300 rounded-lg">
                                    </div>
                                </div>
                            @endif

                            <!-- Cashfree Config -->
                            @if($code === 'cashfree')
                                <div class="bg-green-50 p-4 rounded-lg space-y-3">
                                    <h4 class="font-bold text-sm">Cashfree Credentials</h4>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">App ID</label>
                                        <input type="text" wire:model="appId" class="w-full border-gray-300 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Secret Key</label>
                                        <input type="password" wire:model="secretKey" class="w-full border-gray-300 rounded-lg">
                                    </div>
                                </div>
                            @endif

                            <!-- Rules -->
                            <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                                <h4 class="font-bold text-sm">Payment Rules</h4>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Min Order Value (₹)</label>
                                        <input type="number" wire:model="minOrderValue" class="w-full border-gray-300 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Max Order Value (₹)</label>
                                        <input type="number" wire:model="maxOrderValue" class="w-full border-gray-300 rounded-lg" placeholder="Optional">
                                    </div>
                                </div>

                                @if($code === 'cod')
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">COD Charges (₹)</label>
                                        <input type="number" wire:model="codCharges" class="w-full border-gray-300 rounded-lg">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Available States (comma-separated codes)</label>
                                        <input type="text" wire:model="availableStates" class="w-full border-gray-300 rounded-lg" placeholder="MH, DL, KA, TN">
                                        <p class="text-xs text-gray-500 mt-1">Enter state codes where COD is available</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Status -->
                            <div class="flex items-center gap-6">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="isActive" class="rounded">
                                    <span class="ml-2 text-sm">Active</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="isTestMode" class="rounded">
                                    <span class="ml-2 text-sm">Test Mode</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button wire:click="saveGateway" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Save Configuration
                        </button>
                        <button wire:click="closeModal" class="w-full sm:w-auto px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 mt-2 sm:mt-0">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
