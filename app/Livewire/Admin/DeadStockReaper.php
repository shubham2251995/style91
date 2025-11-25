<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;

class DeadStockReaper extends Component
{
    public function render()
    {
        // Mocking dead stock
        $deadStock = Product::take(3)->get()->map(function($p) {
            $p->days_stagnant = rand(45, 120);
            return $p;
        });

        return view('livewire.admin.dead-stock-reaper', ['deadStock' => $deadStock])->layout('components.layouts.admin');
    }
}
