<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\PaymentGateway;

class PaymentManager extends Component
{
    public $gateways;

    public function mount()
    {
        $this->loadGateways();
    }

    public function loadGateways()
    {
        $this->gateways = PaymentGateway::all();
        
        // Seed if empty
        if ($this->gateways->isEmpty()) {
            PaymentGateway::create(['name' => 'Razorpay', 'slug' => 'razorpay', 'credentials' => ['key' => '', 'secret' => ''], 'is_active' => false]);
            PaymentGateway::create(['name' => 'Cashfree', 'slug' => 'cashfree', 'credentials' => ['app_id' => '', 'secret_key' => ''], 'is_active' => false]);
            PaymentGateway::create(['name' => 'Cash on Delivery', 'slug' => 'cod', 'credentials' => [], 'is_active' => true]);
            $this->loadGateways();
        }
    }

    public function toggle($id)
    {
        $gateway = PaymentGateway::find($id);
        $gateway->update(['is_active' => !$gateway->is_active]);
        $this->loadGateways();
    }

    public function updateCredentials($id, $key, $value)
    {
        $gateway = PaymentGateway::find($id);
        $creds = $gateway->credentials;
        $creds[$key] = $value;
        $gateway->update(['credentials' => $creds]);
        session()->flash('message', 'Credentials Updated!');
    }

    public function render()
    {
        return view('livewire.admin.payment-manager')->layout('components.layouts.app');
    }
}
