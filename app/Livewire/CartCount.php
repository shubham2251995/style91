<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;

class CartCount extends Component
{
    protected $listeners = [
        'cartUpdated' => '$refresh',
        'cart-updated' => '$refresh',
    ];

    public function getCountProperty()
    {
        return app(CartService::class)->count();
    }

    public function render()
    {
        return view('livewire.cart-count');
    }
}
