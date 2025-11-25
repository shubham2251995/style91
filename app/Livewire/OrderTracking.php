<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class OrderTracking extends Component
{
    public $orderId = '';
    public $email = '';
    public $order = null;
    public $error = '';

    public function track()
    {
        $this->error = '';
        $this->order = null;

        $this->validate([
            'orderId' => 'required',
            'email' => 'required|email',
        ]);

        // Find order with eager loading
        $this->order = Order::with(['items.product', 'user'])
            ->where('id', $this->orderId)
            ->where(function($q) {
                $q->where('guest_email', $this->email)
                  ->orWhereHas('user', fn($q) => $q->where('email', $this->email));
            })
            ->first();

        if (!$this->order) {
            $this->error = 'Order not found. Please check your order number and email address.';
        }
    }

    public function render()
    {
        return view('livewire.order-tracking');
    }
}
