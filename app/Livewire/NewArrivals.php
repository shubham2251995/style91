<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class NewArrivals extends Component
{
    use WithPagination;

    public function render()
    {
        $products = Product::where('created_at', '>=', now()->subDays(30))
            ->latest()
            ->paginate(12);

        return view('livewire.new-arrivals', ['products' => $products]);
    }
}
