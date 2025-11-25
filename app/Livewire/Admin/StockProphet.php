<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;

class StockProphet extends Component
{
    public function render()
    {
        $predictions = Product::where('stock_quantity', '>', 0)
            ->take(5)
            ->get()
            ->map(function($product) {
                $dailySales = rand(1, 10);
                $daysLeft = $product->stock_quantity / $dailySales;
                return [
                    'name' => $product->name,
                    'stock' => $product->stock_quantity,
                    'velocity' => $dailySales,
                    'depletion_date' => now()->addDays($daysLeft)->format('M d, Y'),
                    'status' => $daysLeft < 7 ? 'Critical' : ($daysLeft < 30 ? 'Warning' : 'Healthy')
                ];
            });

        return view('livewire.admin.stock-prophet', ['predictions' => $predictions])->layout('components.layouts.admin');
    }
}
