<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithPagination;

class ProductSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $minPrice = '';
    public $maxPrice = '';
    public $sortBy = 'newest';
    public $inStock = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'sortBy' => ['except' => 'newest'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'category', 'minPrice', 'maxPrice', 'sortBy', 'inStock']);
    }

    public function render()
    {
        $query = Product::query();

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
            });
        }

        // Category Filter
        if ($this->category) {
            $query->where('category', $this->category);
        }

        // Price Range
        if ($this->minPrice !== '') {
            $query->where('price', '>=', $this->minPrice);
        }
        if ($this->maxPrice !== '') {
            $query->where('price', '<=', $this->maxPrice);
        }

        // Stock Filter
        if ($this->inStock) {
            $query->where('stock_quantity', '>', 0);
        }

        // Sorting
        switch ($this->sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'best_sellers':
                $query->orderBy('sales_count', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);
        $categories = Product::distinct()->pluck('category')->filter();

        return view('livewire.product-search', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
