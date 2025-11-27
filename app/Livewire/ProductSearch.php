<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $gender = '';
    public $category = '';
    public $tags = [];
    public $minPrice = 0;
    public $maxPrice = 10000;
    public $sortBy = 'latest';
    public $inStock = false;
    public $minRating = 0;
    
    public $showAutocomplete = false;
    public $autocompleteResults = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'sortBy' => ['except' => 'latest'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
        if (strlen($this->search) >= 2) {
            $this->loadAutocomplete();
        } else {
            $this->showAutocomplete = false;
        }
    }

    public function updatedCategory()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function updatedMinPrice()
    {
        $this->resetPage();
    }

    public function updatedMaxPrice()
    {
        $this->resetPage();
    }

    public function updatedTags()
    {
        $this->resetPage();
    }

    public function updatedInStock()
    {
        $this->resetPage();
    }

    public function updatedMinRating()
    {
        $this->resetPage();
    }

    public function loadAutocomplete()
    {
        $this->autocompleteResults = Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->limit(5)
            ->get(['id', 'name', 'slug', 'price', 'image_url'])
            ->toArray();
        
        $this->showAutocomplete = count($this->autocompleteResults) > 0;
    }

    public function selectAutocomplete($slug)
    {
        $this->showAutocomplete = false;
        return redirect()->route('product', ['slug' => $slug]);
    }

    public function clearFilters()
    {
        $this->reset(['category', 'tags', 'minPrice', 'maxPrice', 'sortBy', 'inStock', 'minRating']);
        $this->resetPage();
    }

    public function saveSearch()
    {
        if (Auth::check() && $this->search) {
            try {
                DB::table('search_queries')->insert([
                    'user_id' => Auth::id(),
                    'query' => $this->search,
                    'results_count' => $this->getProductsQuery()->count(),
                    'created_at' => now(),
                ]);
            } catch (\Exception $e) {
                // Table might not exist yet, ignore
            }
        }
    }

    private function getProductsQuery()
    {
        $query = Product::query();

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Gender filter
        if ($this->gender) {
            $query->where('gender', $this->gender);
        }

        // Category filter
        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        // Tags filter
        if (!empty($this->tags)) {
            $query->whereHas('tags', function($q) {
                $q->whereIn('tags.id', $this->tags);
            });
        }

        // Price range filter
        if ($this->minPrice > 0 || $this->maxPrice < 10000) {
            $query->whereBetween('price', [$this->minPrice, $this->maxPrice]);
        }

        // In stock filter
        if ($this->inStock) {
            $query->where('stock_quantity', '>', 0);
        }

        // Rating filter
        if ($this->minRating > 0) {
            $query->whereHas('reviews', function($q) {
                $q->approved();
            })->withAvg('reviews', 'rating')
              ->having('reviews_avg_rating', '>=', $this->minRating);
        }

        // Sorting
        switch ($this->sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->withCount('reviews')->orderBy('reviews_count', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                break;
            default: // latest
                $query->latest();
        }

        return $query;
    }

    public function render()
    {
        $this->saveSearch();

        $products = $this->getProductsQuery()->paginate(20);
        $categories = Category::active()->get();
        $allTags = Tag::all();

        // Get trending searches
        $trendingSearches = [];
        try {
            $trendingSearches = DB::table('search_queries')
                ->select('query', DB::raw('COUNT(*) as count'))
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('query')
                ->orderBy('count', 'desc')
                ->limit(8)
                ->pluck('query')
                ->toArray();
        } catch (\Exception $e) {
            // Table might not exist yet
        }

        return view('livewire.product-search', [
            'products' => $products,
            'categories' => $categories,
            'allTags' => $allTags,
            'trendingSearches' => $trendingSearches,
        ]);
    }
}
