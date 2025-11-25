<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\StockAlert;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class StockAlertButton extends Component
{
    public $productId;
    public $subscribed = false;

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->checkSubscription();
    }

    public function checkSubscription()
    {
        if (Auth::check()) {
            $this->subscribed = StockAlert::isSubscribed(Auth::id(), $this->productId);
        }
    }

    public function toggle()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->subscribed) {
            StockAlert::where('user_id', Auth::id())
                ->where('product_id', $this->productId)
                ->delete();
            $this->subscribed = false;
            session()->flash('success', 'Stock alert removed');
        } else {
            StockAlert::subscribe(Auth::id(), $this->productId);
            $this->subscribed = true;
            session()->flash('success', 'You\'ll be notified when this product is back in stock!');
        }
    }

    public function render()
    {
        return view('livewire.stock-alert-button');
    }
}
