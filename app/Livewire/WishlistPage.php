<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Wishlist;
use App\Models\WishlistAlert;
use Illuminate\Support\Facades\Auth;

class WishlistPage extends Component
{
    use WithPagination;

    public $showAlertModal = false;
    public $selectedProductId;
    public $alertType = 'price_drop';
    public $thresholdPrice;

    public function removeFromWishlist($productId)
    {
        Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();

        session()->flash('message', 'Item removed from wishlist');
    }

    public function moveToCart($productId)
    {
        // Add to cart logic (assuming you have a cart system)
        session()->flash('message', 'Item moved to cart');
        $this->removeFromWishlist($productId);
    }

    public function openAlertModal($productId)
    {
        $this->selectedProductId = $productId;
        $this->showAlertModal = true;
    }

    public function closeAlertModal()
    {
        $this->showAlertModal = false;
        $this->reset(['selectedProductId', 'alertType', 'thresholdPrice']);
    }

    public function setAlert()
    {
        $this->validate([
            'alertType' => 'required|in:price_drop,back_in_stock',
            'thresholdPrice' => 'required_if:alertType,price_drop|nullable|numeric|min:0',
        ]);

        WishlistAlert::create([
            'user_id' => Auth::id(),
            'product_id' => $this->selectedProductId,
            'alert_type' => $this->alertType,
            'threshold_price' => $this->alertType === 'price_drop' ? $this->thresholdPrice : null,
        ]);

        session()->flash('message', 'Alert set successfully!');
        $this->closeAlertModal();
    }

    public function shareWishlist()
    {
        $shareUrl = route('shared-wishlist', ['user' => Auth::id()]);
        // Copy to clipboard via JavaScript
        $this->dispatch('copyToClipboard', url: $shareUrl);
        session()->flash('message', 'Wishlist link copied to clipboard!');
    }

    public function render()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())
                             ->with('product')
                             ->latest()
                             ->paginate(12);

        return view('livewire.wishlist-page', [
            'wishlists' => $wishlists,
        ]);
    }
}
