<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductComparison extends Component
{
    public $compareProducts = [];
    public $maxProducts = 4;

    public function mount()
    {
        $this->loadCompareList();
    }

    public function loadCompareList()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        $productIds = DB::table('product_comparisons')
            ->where(function($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->latest()
            ->limit($this->maxProducts)
            ->pluck('product_id');

        $this->compareProducts = Product::whereIn('id', $productIds)->get();
    }

    public function addToCompare($productId)
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        // Check if already in comparison
        $exists = DB::table('product_comparisons')
            ->where('product_id', $productId)
            ->where(function($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->exists();

        if (!$exists) {
            // Check limit
            $count = DB::table('product_comparisons')
                ->where(function($q) use ($userId, $sessionId) {
                    if ($userId) {
                        $q->where('user_id', $userId);
                    } else {
                        $q->where('session_id', $sessionId);
                    }
                })
                ->count();

            if ($count >= $this->maxProducts) {
                session()->flash('error', 'You can compare maximum ' . $this->maxProducts . ' products');
                return;
            }

            DB::table('product_comparisons')->insert([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'product_id' => $productId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            session()->flash('message', 'Product added to comparison');
        }

        $this->loadCompareList();
    }

    public function removeFromCompare($productId)
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        DB::table('product_comparisons')
            ->where('product_id', $productId)
            ->where(function($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->delete();

        session()->flash('message', 'Product removed from comparison');
        $this->loadCompareList();
    }

    public function clearAll()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        DB::table('product_comparisons')
            ->where(function($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->delete();

        $this->compareProducts = collect();
        session()->flash('message', 'Comparison cleared');
    }

    public function render()
    {
        return view('livewire.product-comparison');
    }
}
