<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class Checkout extends Component
{
    public $step = 1;

    protected $listeners = ['goToPayment' => 'advanceToPayment'];

    public function mount()
    {
        if (!app(CartService::class)->count()) {
            return redirect()->route('cart');
        }
    }

    public function advanceToPayment()
    {
        $this->step = 2;
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
