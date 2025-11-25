<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class SmartBundling extends Component
{
    public $product;
    public $bundleItems;

    public function mount($productId = null)
    {
        if ($productId) {
            $this->product = Product::find($productId);
            // Mock bundle suggestions
            $this->bundleItems = Product::where('id', '!=', $productId)
                ->inRandomOrder()
                ->take(2)
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.smart-bundling');
    }
}
