<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class SalePage extends Component
{
    use WithPagination;

    public function render()
    {
        // Products with price > 0 and on sale (you can add an 'on_sale' column or discount logic)
        $products = Product::whereNotNull('price')
            ->where('price', '>', 0)
            ->latest()
            ->paginate(12);

        return view('livewire.sale-page', ['products' => $products]);
    }
}
