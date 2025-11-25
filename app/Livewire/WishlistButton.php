<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistButton extends Component
{
    public $productId;
    public $isInWishlist = false;

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->checkWishlist();
    }

    public function checkWishlist()
    {
        if (Auth::check()) {
            $this->isInWishlist = Wishlist::isInWishlist(Auth::id(), $this->productId);
        }
    }

    public function toggle()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->isInWishlist = Wishlist::toggle(Auth::id(), $this->productId);
        
        $this->dispatch('wishlist-updated');
    }

    public function render()
    {
        return view('livewire.wishlist-button');
    }
}
