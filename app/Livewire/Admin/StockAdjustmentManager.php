<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockAdjustment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockAdjustmentManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $productId;
    public $variantId;
    public $quantityChange = 0;
    public $reason = 'manual';
    public $notes = '';
    public $searchTerm = '';
    public $selectedProduct;
    public $selectedVariant;

    protected $rules = [
        'productId' => 'required|exists:products,id',
        'quantityChange' => 'required|integer|not_in:0',
        'reason' => 'required|in:damaged,returned,lost,found,manual,correction,supplier',
        'notes' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'quantityChange.not_in' => 'Quantity change cannot be zero.',
    ];

    public function openModal()
    {
        $this->reset(['productId', 'variantId', 'quantityChange', 'reason', 'notes', 'selectedProduct', 'selectedVariant']);
        $this->showModal = true;
    }

    public function selectProduct($productId)
    {
        $this->productId = $productId;
        $this->selectedProduct = Product::with('variants')->find($productId);
        $this->variantId = null;
        $this->selectedVariant = null;
    }

    public function selectVariant($variantId)
    {
        $this->variantId = $variantId;
        $this->selectedVariant = ProductVariant::find($variantId);
    }

    public function adjustStock()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($this->productId);
            
            if ($this->variantId) {
                $variant = ProductVariant::findOrFail($this->variantId);
                $oldQuantity = $variant->stock_quantity ?? 0;
                $newQuantity = max(0, $oldQuantity + $this->quantityChange);
                
                $variant->update(['stock_quantity' => $newQuantity]);
                
                StockAdjustment::create([
                    'product_id' => $this->productId,
                    'variant_id' => $this->variantId,
                    'user_id' => Auth::id(),
                    'quantity_change' => $this->quantityChange,
                    'old_quantity' => $oldQuantity,
                    'new_quantity' => $newQuantity,
                    'reason' => $this->reason,
                    'notes' => $this->notes,
                ]);
            } else {
                $oldQuantity = $product->stock_quantity;
                $newQuantity = max(0, $oldQuantity + $this->quantityChange);
                
                $product->update(['stock_quantity' => $newQuantity]);
                
                StockAdjustment::create([
                    'product_id' => $this->productId,
                    'user_id' => Auth::id(),
                    'quantity_change' => $this->quantityChange,
                    'old_quantity' => $oldQuantity,
                    'new_quantity' => $newQuantity,
                    'reason' => $this->reason,
                    'notes' => $this->notes,
                ]);
            }

            DB::commit();
            
            $this->showModal = false;
            session()->flash('message', 'Stock adjusted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to adjust stock: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $adjustments = StockAdjustment::with(['product', 'variant', 'user'])
            ->latest()
            ->paginate(20);

        $products = Product::when($this->searchTerm, function($query) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        })->get();

        return view('livewire.admin.stock-adjustment-manager', [
            'adjustments' => $adjustments,
            'products' => $products,
        ]);
    }
}
