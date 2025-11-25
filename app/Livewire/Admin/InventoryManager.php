<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class InventoryManager extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $filterCategory = '';
    public $filterStock = 'all';
    public $lowStockThreshold = 10;

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::with('category');

        // Search
        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('slug', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Filter by category
        if ($this->filterCategory) {
            $query->where('category_id', $this->filterCategory);
        }

        // Filter by stock status
        if ($this->filterStock === 'low') {
            $query->where('stock_quantity', '<', $this->lowStockThreshold)
                  ->where('stock_quantity', '>', 0);
        } elseif ($this->filterStock === 'out') {
            $query->where('stock_quantity', 0);
        } elseif ($this->filterStock === 'in') {
            $query->where('stock_quantity', '>', $this->lowStockThreshold);
        }

        $products = $query->latest()->paginate(20);

        // Stats
        $totalProducts = Product::count();
        $lowStockCount = Product::where('stock_quantity', '<', $this->lowStockThreshold)
                                ->where('stock_quantity', '>', 0)
                                ->count();
        $outOfStockCount = Product::where('stock_quantity', 0)->count();
        $totalValue = Product::sum(\DB::raw('price * stock_quantity'));

        return view('livewire.admin.inventory-manager', [
            'products' => $products,
            'categories' => Category::active()->orderBy('name')->get(),
            'stats' => [
                'total' => $totalProducts,
                'low_stock' => $lowStockCount,
                'out_of_stock' => $outOfStockCount,
                'total_value' => $totalValue,
            ],
        ]);
    }
}
