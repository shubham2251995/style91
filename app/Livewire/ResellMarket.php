<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ResellMarket extends Component
{
    public function render()
    {
        // Mocking resell listings using existing products
        $listings = Product::inRandomOrder()->take(6)->get()->map(function($product) {
            $product->resell_price = $product->price * rand(1.2, 3.0);
            $product->seller = 'User' . rand(100, 999);
            return $product;
        });

        return view('livewire.resell-market', [
            'listings' => $listings
        ])->layout('components.layouts.app');
    }
}
