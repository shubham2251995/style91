<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductRecommendations extends Component
{
    public $product; // Current product being viewed
    public $type = 'related'; // related, similar, frequently_bought, personalized
    public $limit = 8;

    public function mount($product = null, $type = 'related', $limit = 8)
    {
        $this->product = $product;
        $this->type = $type;
        $this->limit = $limit;
    }

    public function render()
    {
        $recommendations = collect();

        switch ($this->type) {
            case 'related':
                $recommendations = $this->getRelatedProducts();
                break;
            case 'similar':
                $recommendations = $this->getSimilarProducts();
                break;
            case 'frequently_bought':
                $recommendations = $this->getFrequentlyBoughtTogether();
                break;
            case 'personalized':
                $recommendations = $this->getPersonalizedRecommendations();
                break;
            case 'trending':
                $recommendations = $this->getTrendingProducts();
                break;
        }

        return view('livewire.product-recommendations', [
            'recommendations' => $recommendations,
        ]);
    }

    private function getRelatedProducts()
    {
        if (!$this->product) {
            return collect();
        }

        // Get products from same category, exclude current product
        return Product::where('category_id', $this->product->category_id)
            ->where('id', '!=', $this->product->id)
            ->where('stock_quantity', '>', 0)
            ->inRandomOrder()
            ->limit($this->limit)
            ->get();
    }

    private function getSimilarProducts()
    {
        if (!$this->product) {
            return collect();
        }

        // Get products with similar price range and same tags
        $minPrice = $this->product->price * 0.7;
        $maxPrice = $this->product->price * 1.3;

        $tagIds = $this->product->tags->pluck('id');

        return Product::where('id', '!=', $this->product->id)
            ->whereBetween('price', [$minPrice, $maxPrice])
            ->where('stock_quantity', '>', 0)
            ->when($tagIds->count() > 0, function($q) use ($tagIds) {
                $q->whereHas('tags', function($query) use ($tagIds) {
                    $query->whereIn('tags.id', $tagIds);
                });
            })
            ->inRandomOrder()
            ->limit($this->limit)
            ->get();
    }

    private function getFrequentlyBoughtTogether()
    {
        if (!$this->product) {
            return collect();
        }

        // Get products that were ordered together with this product
        return Product::whereHas('orderItems', function($q) {
                $q->whereIn('order_id', function($subQ) {
                    $subQ->select('order_id')
                         ->from('order_items')
                         ->where('product_id', $this->product->id);
                });
            })
            ->where('id', '!=', $this->product->id)
            ->where('stock_quantity', '>', 0)
            ->select('products.*', DB::raw('COUNT(*) as frequency'))
            ->groupBy('products.id')
            ->orderBy('frequency', 'desc')
            ->limit($this->limit)
            ->get();
    }

    private function getPersonalizedRecommendations()
    {
        if (!Auth::check()) {
            return $this->getTrendingProducts();
        }

        // Get categories from user's order history
        $categorieIds = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.user_id', Auth::id())
            ->distinct()
            ->pluck('products.category_id');

        if ($categorieIds->isEmpty()) {
            return $this->getTrendingProducts();
        }

        // Get products from user's favorite categories
        return Product::whereIn('category_id', $categorieIds)
            ->where('stock_quantity', '>', 0)
            ->when($this->product, function($q) {
                $q->where('id', '!=', $this->product->id);
            })
            ->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->limit($this->limit)
            ->get();
    }

    private function getTrendingProducts()
    {
        // Products with most orders in last 30 days
        return Product::whereHas('orderItems', function($q) {
                $q->whereHas('order', function($orderQ) {
                    $orderQ->where('created_at', '>=', now()->subDays(30));
                });
            })
            ->where('stock_quantity', '>', 0)
            ->when($this->product, function($q) {
                $q->where('id', '!=', $this->product->id);
            })
            ->withCount(['orderItems' => function($q) {
                $q->whereHas('order', function($orderQ) {
                    $orderQ->where('created_at', '>=', now()->subDays(30));
                });
            }])
            ->orderBy('order_items_count', 'desc')
            ->limit($this->limit)
            ->get();
    }
}
