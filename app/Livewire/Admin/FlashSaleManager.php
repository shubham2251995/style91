<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\FlashSale;
use App\Models\Product;

class FlashSaleManager extends Component
{
    // Campaign Fields
    public $saleId;
    public $name;
    public $slug;
    public $startTime;
    public $endTime;
    public $isActive = true;
    
    // Product Management
    public $selectedProducts = [];
    public $discountPercentage;
    public $fixedPrice;
    
    public $showModal = false;
    public $showProductModal = false;
    public $activeSale;

    protected $rules = [
        'name' => 'required|string|max:255',
        'startTime' => 'required|date',
        'endTime' => 'required|date|after:startTime',
    ];

    public function create()
    {
        $this->reset(['saleId', 'name', 'slug', 'startTime', 'endTime']);
        $this->isActive = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        FlashSale::updateOrCreate(['id' => $this->saleId], [
            'name' => $this->name,
            'slug' => \Illuminate\Support\Str::slug($this->name),
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'is_active' => $this->isActive,
        ]);

        $this->showModal = false;
        session()->flash('message', 'Flash sale campaign saved successfully.');
    }

    public function manageProducts($id)
    {
        $this->activeSale = FlashSale::with('products')->findOrFail($id);
        $this->showProductModal = true;
    }

    public function addProduct($productId)
    {
        if (!$this->activeSale) return;

        $this->activeSale->products()->attach($productId, [
            'discount_percentage' => $this->discountPercentage,
            'fixed_price' => $this->fixedPrice
        ]);
        
        $this->activeSale->refresh();
        session()->flash('message', 'Product added to flash sale.');
    }

    public function removeProduct($productId)
    {
        if (!$this->activeSale) return;
        
        $this->activeSale->products()->detach($productId);
        $this->activeSale->refresh();
    }

    public function delete($id)
    {
        FlashSale::findOrFail($id)->delete();
    }

    public function render()
    {
        $sales = FlashSale::withCount('products')->latest()->get();
        $products = Product::all(); // Should be paginated/searched in real app

        return view('livewire.admin.flash-sale-manager', [
            'sales' => $sales,
            'products' => $products,
        ]);
    }
}
