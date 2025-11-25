<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Services\CartService;

class BulkOrder extends Component
{
    public $products;
    public $quantities = [];
    public $search = '';

    public function mount()
    {
        $this->products = Product::all();
        foreach ($this->products as $product) {
            $this->quantities[$product->id] = 0;
        }
    }

    public function updatedSearch()
    {
        $this->products = Product::where('name', 'like', '%' . $this->search . '%')->get();
    }

    public function increment($productId)
    {
        $this->quantities[$productId]++;
    }

    public function decrement($productId)
    {
        if ($this->quantities[$productId] > 0) {
            $this->quantities[$productId]--;
        }
    }

    public function addToCart(CartService $cartService)
    {
        $count = 0;
        foreach ($this->quantities as $productId => $qty) {
            if ($qty > 0) {
                $cartService->add($productId, $qty);
                $this->quantities[$productId] = 0; // Reset after adding
                $count += $qty;
            }
        }

        if ($count > 0) {
            session()->flash('message', "Added $count items to cart.");
            $this->dispatch('cart-updated'); // Optional: if we had a cart counter listener
            return redirect()->route('cart');
        }
    }

    public function render()
    {
        return view('livewire.bulk-order')->layout('components.layouts.app');
    }
}
