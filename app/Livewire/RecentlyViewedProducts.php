<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RecentlyViewed;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class RecentlyViewedProducts extends Component
{
    public $limit = 8;

    public function render()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        $recentlyViewed = RecentlyViewed::with('product')
            ->where(function($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->orderBy('viewed_at', 'desc')
            ->limit($this->limit)
            ->get()
            ->pluck('product')
            ->filter(); // Remove null products

        return view('livewire.recently-viewed-products', [
            'products' => $recentlyViewed,
        ]);
    }
}
