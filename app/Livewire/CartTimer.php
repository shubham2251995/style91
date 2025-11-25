<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;

class CartTimer extends Component
{
    public $timeLeft;
    public $isActive = false;

    public function mount()
    {
        $this->checkTimer();
    }

    public function checkTimer()
    {
        $cartService = app(CartService::class);
        if ($cartService->count() > 0) {
            $expiresAt = session()->get('cart_expires_at');
            if ($expiresAt) {
                $this->isActive = true;
                $this->timeLeft = now()->diffInSeconds($expiresAt, false);
                
                if ($this->timeLeft <= 0) {
                    $cartService->clear();
                    $this->redirect(route('cart'));
                }
            }
        } else {
            $this->isActive = false;
        }
    }

    public function render()
    {
        $this->checkTimer();
        return view('livewire.cart-timer');
    }
}
