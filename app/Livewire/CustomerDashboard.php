<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class CustomerDashboard extends Component
{
    public $activeTab = 'orders';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $user = Auth::user();
        
        $orders = Order::where('user_id', $user->id)
            ->with('items.product')
            ->latest()
            ->paginate(10);

        $wishlist = Wishlist::where('user_id', $user->id)
            ->with('product')
            ->latest()
            ->get();

        $addresses = Address::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('livewire.customer-dashboard', [
            'orders' => $orders,
            'wishlist' => $wishlist,
            'addresses' => $addresses,
            'user' => $user,
        ]);
    }
}
