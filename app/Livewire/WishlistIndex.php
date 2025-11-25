<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Wishlist;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class WishlistIndex extends Component
{
    protected $listeners = ['wishlist-updated' => '$refresh'];

    public function removeFromWishlist($productId)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();
    }

    public function moveToCart($productId)
    {
        app(CartService::class)->add($productId, 1);
        $this->removeFromWishlist($productId);
        
        session()->flash('success', 'Item moved to cart!');
    }

    public function render()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();

        return view('livewire.wishlist-index', [
            'wishlistItems' => $wishlistItems,
        ]);
    }
}
