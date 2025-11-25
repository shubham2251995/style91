<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class QuickView extends Component
{
    public $productId;
    public $product;
    public $show = false;

    protected $listeners = ['openQuickView'];

    public function openQuickView($productId)
    {
        $this->productId = $productId;
        $this->product = Product::findOrFail($productId);
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
        $this->product = null;
    }

    public function render()
    {
        return view('livewire.quick-view');
    }
}
