<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CartItem;
use App\Models\User;
use Carbon\Carbon;

class AbandonedCartManager extends Component
{
    use WithPagination;

    public function render()
    {
        // Define abandoned as not updated in the last 1 hour
        $cutoff = Carbon::now()->subHour();

        // Group by user_id or session_id
        // Since we can't easily paginate grouped results with Eloquent builder directly in a simple way without raw queries or advanced techniques,
        // and assuming the scale isn't massive yet, we'll fetch unique sessions/users first.
        
        // Better approach: Get distinct user_ids and session_ids from cart_items where updated_at < cutoff
        // This is a bit complex. Let's simplify: List cart items, but grouped in the view? No, that messes up pagination.
        
        // Let's use a raw query to get "carts"
        // A "cart" is defined by a user_id (if logged in) or session_id (if guest)
        
        $carts = CartItem::select('user_id', 'session_id')
            ->where('updated_at', '<', $cutoff)
            ->distinct()
            ->paginate(20);

        // For each cart, we need to fetch the items and total value
        // We can do this in the view or transform the collection
        
        $cartDetails = $carts->getCollection()->map(function ($cart) {
            $query = CartItem::with('product');
            if ($cart->user_id) {
                $query->where('user_id', $cart->user_id);
                $user = User::find($cart->user_id);
                $customerName = $user ? $user->name : 'Unknown User';
                $customerEmail = $user ? $user->email : '—';
            } else {
                $query->where('session_id', $cart->session_id)->whereNull('user_id');
                $customerName = 'Guest';
                $customerEmail = '—';
            }
            
            $items = $query->get();
            $total = $items->sum(function ($item) {
                return $item->price * $item->quantity;
            });
            $lastUpdate = $items->max('updated_at');

            return (object) [
                'user_id' => $cart->user_id,
                'session_id' => $cart->session_id,
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'items_count' => $items->count(),
                'total' => $total,
                'last_update' => $lastUpdate,
                'items' => $items
            ];
        });

        // Replace the collection in the paginator
        $carts->setCollection($cartDetails);

        return view('livewire.admin.abandoned-cart-manager', [
            'carts' => $carts
        ]);
    }
}
