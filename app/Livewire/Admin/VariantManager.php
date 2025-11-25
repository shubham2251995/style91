<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ProductVariant;
use App\Models\VariantOption;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class VariantManager extends Component
{
    public $variants = [];
    public $options = [];
    public $productId;
    public $showModal = false;
    public $variantId = null;
    public $sku;
    public $price;
    public $compare_price;
    public $stock_quantity;
    public $image_url;
    public $is_active = true;
    public $optionValues = [];

    protected $rules = [
        'productId' => 'required|exists:products,id',
        'sku' => 'required|string',
        'price' => 'required|numeric',
        'compare_price' => 'nullable|numeric',
        'stock_quantity' => 'required|integer',
        'image_url' => 'nullable|url',
        'is_active' => 'boolean',
        'optionValues.*' => 'required|string',
    ];

    public function mount()
    {
        $this->loadVariants();
        $this->products = Product::all();
    }

    public function loadVariants()
    {
        $this->variants = ProductVariant::with('product')->orderBy('id', 'desc')->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $this->variantId = $variant->id;
        $this->productId = $variant->product_id;
        $this->sku = $variant->sku;
        $this->price = $variant->price;
        $this->compare_price = $variant->compare_price;
        $this->stock_quantity = $variant->stock_quantity;
        $this->image_url = $variant->image_url;
        $this->is_active = $variant->is_active;
        $this->optionValues = $variant->options ?? [];
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();
        DB::transaction(function () {
            $data = [
                'product_id' => $this->productId,
                'sku' => $this->sku,
                'price' => $this->price,
                'compare_price' => $this->compare_price,
                'stock_quantity' => $this->stock_quantity,
                'image_url' => $this->image_url,
                'options' => $this->optionValues,
                'is_active' => $this->is_active,
            ];
            if ($this->variantId) {
                ProductVariant::findOrFail($this->variantId)->update($data);
            } else {
                ProductVariant::create($data);
            }
        });
        $this->showModal = false;
        $this->loadVariants();
    }

    public function delete($id)
    {
        ProductVariant::findOrFail($id)->delete();
        $this->loadVariants();
    }

    private function resetForm()
    {
        $this->variantId = null;
        $this->productId = null;
        $this->sku = '';
        $this->price = '';
        $this->compare_price = '';
        $this->stock_quantity = '';
        $this->image_url = '';
        $this->is_active = true;
        $this->optionValues = [];
    }

    public function render()
    {
        return view('livewire.admin.variant-manager');
    }
}
