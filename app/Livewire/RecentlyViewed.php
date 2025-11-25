<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class RecentlyViewed extends Component
{
    public function render()
    {
        $viewedIds = session('recently_viewed', []);
        
        if (empty($viewedIds)) {
            return view('livewire.recently-viewed', ['products' => collect()]);
        }

        // Preserve order from session
        $products = Product::whereIn('id', $viewedIds)
            ->get()
            ->sortBy(function($product) use ($viewedIds) {
                return array_search($product->id, $viewedIds);
            })
            ->take(6);

        return view('livewire.recently-viewed', ['products' => $products]);
    }
}
