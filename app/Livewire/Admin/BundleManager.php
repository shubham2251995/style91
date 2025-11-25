<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ProductBundle;
use App\Models\BundleProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class BundleManager extends Component
{
    public $bundles = [];
    public $products = [];
    public $bundleId = null;
    public $name;
    public $description;
    public $slug;
    public $image_url;
    public $price;
    public $compare_price;
    public $discount_percentage = 0;
    public $stock_quantity = 0;
    public $is_active = true;
    public $selectedProducts = [];
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string',
        'slug' => 'required|string|unique:product_bundles,slug',
        'price' => 'required|numeric',
        'compare_price' => 'nullable|numeric',
        'discount_percentage' => 'required|integer|min:0|max:100',
        'stock_quantity' => 'required|integer|min:0',
        'is_active' => 'boolean',
        'selectedProducts.*.product_id' => 'required|exists:products,id',
        'selectedProducts.*.quantity' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->loadBundles();
        $this->products = Product::all();
    }

    public function loadBundles()
    {
        $this->bundles = ProductBundle::with('bundleProducts.product')->orderBy('id', 'desc')->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $bundle = ProductBundle::with('bundleProducts')->findOrFail($id);
        $this->bundleId = $bundle->id;
        $this->name = $bundle->name;
        $this->description = $bundle->description;
        $this->slug = $bundle->slug;
        $this->image_url = $bundle->image_url;
        $this->price = $bundle->price;
        $this->compare_price = $bundle->compare_price;
        $this->discount_percentage = $bundle->discount_percentage;
        $this->stock_quantity = $bundle->stock_quantity;
        $this->is_active = $bundle->is_active;
        $this->selectedProducts = $bundle->bundleProducts->map(function ($bp) {
            return ['product_id' => $bp->product_id, 'quantity' => $bp->quantity];
        })->toArray();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();
        DB::transaction(function () {
            $data = [
                'name' => $this->name,
                'description' => $this->description,
                'slug' => $this->slug,
                'image_url' => $this->image_url,
                'price' => $this->price,
                'compare_price' => $this->compare_price,
                'discount_percentage' => $this->discount_percentage,
                'stock_quantity' => $this->stock_quantity,
                'is_active' => $this->is_active,
            ];
            if ($this->bundleId) {
                $bundle = ProductBundle::findOrFail($this->bundleId);
                $bundle->update($data);
            } else {
                $bundle = ProductBundle::create($data);
            }
            // Sync bundle products
            $bundle->bundleProducts()->delete();
            foreach ($this->selectedProducts as $item) {
                BundleProduct::create([
                    'bundle_id' => $bundle->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });
        $this->showModal = false;
        $this->loadBundles();
    }

    public function delete($id)
    {
        $bundle = ProductBundle::findOrFail($id);
        $bundle->delete();
        $this->loadBundles();
    }

    private function resetForm()
    {
        $this->bundleId = null;
        $this->name = '';
        $this->description = '';
        $this->slug = '';
        $this->image_url = '';
        $this->price = '';
        $this->compare_price = '';
        $this->discount_percentage = 0;
        $this->stock_quantity = 0;
        $this->is_active = true;
        $this->selectedProducts = [];
    }

    public function render()
    {
        return view('livewire.admin.bundle-manager');
    }
}
