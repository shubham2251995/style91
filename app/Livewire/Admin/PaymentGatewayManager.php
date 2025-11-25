<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\PaymentGateway;

class PaymentGatewayManager extends Component
{
    public $gateways;
    public $selectedGateway;
    public $isModalOpen = false;

    // Form fields
    public $gatewayId;
    public $name;
    public $code;
    public $description;
    public $isActive = true;
    public $isTestMode = true;
    
    // Config
    public $apiKey;
    public $apiSecret;
    public $appId;
    public $secretKey;
    
    // Rules
    public $minOrderValue = 0;
    public $maxOrderValue;
    public $codCharges = 0;
    public $availableStates = [];

    public function mount()
    {
        $this->loadGateways();
    }

    public function loadGateways()
    {
        $this->gateways = PaymentGateway::orderBy('display_order')->get();
    }

    public function createDefaultGateways()
    {
        // Razorpay
        PaymentGateway::firstOrCreate(
            ['code' => 'razorpay'],
            [
                'name' => 'Razorpay',
                'description' => 'Pay securely using UPI, Cards, Net Banking & Wallets',
                'config' => [
                    'api_key' => '',
                    'api_secret' => '',
                ],
                'rules' => [
                    'min_order_value' => 1,
                ],
                'is_active' => false,
                'is_test_mode' => true,
                'display_order' => 1,
            ]
        );

        // Cashfree
        PaymentGateway::firstOrCreate(
            ['code' => 'cashfree'],
            [
                'name' => 'Cashfree',
                'description' => 'Fast & secure payments',
                'config' => [
                    'app_id' => '',
                    'secret_key' => '',
                ],
                'rules' => [
                    'min_order_value' => 1,
                ],
                'is_active' => false,
                'is_test_mode' => true,
                'display_order' => 2,
            ]
        );

        // Cash on Delivery
        PaymentGateway::firstOrCreate(
            ['code' => 'cod'],
            [
                'name' => 'Cash on Delivery',
                'description' => 'Pay when you receive your order',
                'config' => [],
                'rules' => [
                    'min_order_value' => 0,
                    'max_order_value' => 50000,
                    'cod_charges' => 50,
                    'available_states' => ['MH', 'DL', 'KA', 'TN', 'UP', 'GJ'],
                ],
                'is_active' => true,
                'is_test_mode' => false,
                'display_order' => 3,
            ]
        );

        $this->loadGateways();
        session()->flash('message', 'Default payment gateways created successfully!');
    }

    public function editGateway($id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        
        $this->gatewayId = $gateway->id;
        $this->name = $gateway->name;
        $this->code = $gateway->code;
        $this->description = $gateway->description;
        $this->isActive = $gateway->is_active;
        $this->isTestMode = $gateway->is_test_mode;
        
        // Load config
        if ($gateway->code === 'razorpay') {
            $this->apiKey = $gateway->getConfigValue('api_key');
            $this->apiSecret = $gateway->getConfigValue('api_secret');
        } elseif ($gateway->code === 'cashfree') {
            $this->appId = $gateway->getConfigValue('app_id');
            $this->secretKey = $gateway->getConfigValue('secret_key');
        }
        
        // Load rules
        $rules = $gateway->rules ?? [];
        $this->minOrderValue = $rules['min_order_value'] ?? 0;
        $this->maxOrderValue = $rules['max_order_value'] ?? null;
        $this->codCharges = $rules['cod_charges'] ?? 0;
        $this->availableStates = $rules['available_states'] ?? [];
        
        $this->isModalOpen = true;
    }

    public function saveGateway()
    {
        $gateway = PaymentGateway::findOrFail($this->gatewayId);
        
        $config = [];
        if ($this->code === 'razorpay') {
            $config = [
                'api_key' => $this->apiKey,
                'api_secret' => $this->apiSecret,
            ];
        } elseif ($this->code === 'cashfree') {
            $config = [
                'app_id' => $this->appId,
                'secret_key' => $this->secretKey,
            ];
        }
        
        $rules = [
            'min_order_value' => $this->minOrderValue,
        ];
        
        if ($this->maxOrderValue) {
            $rules['max_order_value'] = $this->maxOrderValue;
        }
        
        if ($this->code === 'cod') {
            $rules['cod_charges'] = $this->codCharges;
            $rules['available_states'] = $this->availableStates;
        }
        
        $gateway->update([
            'description' => $this->description,
            'config' => $config,
            'rules' => $rules,
            'is_active' => $this->isActive,
            'is_test_mode' => $this->isTestMode,
        ]);

        session()->flash('message', 'Payment gateway updated successfully!');
        $this->closeModal();
        $this->loadGateways();
    }

    public function toggleStatus($id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        $gateway->update(['is_active' => !$gateway->is_active]);
        $this->loadGateways();
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset(['gatewayId', 'name', 'code', 'description', 'apiKey', 'apiSecret', 'appId', 'secretKey']);
    }

    public function render()
    {
        return view('livewire.admin.payment-gateway-manager');
    }
}
