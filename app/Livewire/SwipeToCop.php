<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Services\CartService;

class SwipeToCop extends Component
{
    public $products;
    public $currentIndex = 0;

    public function mount()
    {
        $this->products = Product::inRandomOrder()->take(10)->get();
    }

    public function swipeRight(CartService $cartService)
    {
        if (isset($this->products[$this->currentIndex])) {
            $product = $this->products[$this->currentIndex];
            $cartService->add($product->id);
            $this->dispatch('notify', message: "Added {$product->name} to cart!");
        }
        $this->next();
    }

    public function swipeLeft()
    {
        $this->next();
    }

    public function next()
    {
        $this->currentIndex++;
    }

    public function render()
    {
        return view('livewire.swipe-to-cop', [
            'currentProduct' => $this->products[$this->currentIndex] ?? null
        ])->layout('components.layouts.app');
    }
}
