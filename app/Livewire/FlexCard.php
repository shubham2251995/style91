<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class FlexCard extends Component
{
    public Order $order;

    public function mount($orderId)
    {
        $this->order = Order::with('items')->findOrFail($orderId);
        
        // Security check: only allow owner to view (or public if we want it shareable, let's keep it public for "Flex" factor but maybe obfuscate details later)
        // For now, open to all for sharing purposes.
    }

    public function render()
    {
        return view('livewire.flex-card')->layout('components.layouts.app');
    }
}
