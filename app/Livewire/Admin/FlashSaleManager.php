<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\FlashSale;
use App\Models\Product;

class FlashSaleManager extends Component
{
    public $productId;
    public $discountPercentage;
    public $startTime;
    public $endTime;
    public $isActive = true;
    public $showModal = false;

    protected $rules = [
        'productId' => 'required|exists:products,id',
        'discountPercentage' => 'required|integer|min:1|max:100',
        'startTime' => 'required|date',
        'endTime' => 'required|date|after:startTime',
    ];

    public function create()
    {
        $this->reset(['productId', 'discountPercentage', 'startTime', 'endTime']);
        $this->isActive = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        FlashSale::create([
            'product_id' => $this->productId,
            'discount_percentage' => $this->discountPercentage,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'is_active' => $this->isActive,
        ]);

        $this->showModal = false;
        session()->flash('message', 'Flash sale created successfully.');
    }

    public function toggleStatus($id)
    {
        $sale = FlashSale::findOrFail($id);
        $sale->update(['is_active' => !$sale->is_active]);
    }

    public function delete($id)
    {
        FlashSale::findOrFail($id)->delete();
    }

    public function render()
    {
        $sales = FlashSale::with('product')->latest()->get();
        $products = Product::all();

        return view('livewire.admin.flash-sale-manager', [
            'sales' => $sales,
            'products' => $products,
        ]);
    }
}
