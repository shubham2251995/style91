<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProfitPilot extends Component
{
    public function render()
    {
        // Calculate basic metrics
        $totalRevenue = Order::sum('total_amount');
        $totalOrders = Order::count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        // Top selling products
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'), DB::raw('SUM(order_items.price * order_items.quantity) as revenue'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('revenue')
            ->take(5)
            ->get();

        // Recent sales
        $recentSales = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.admin.profit-pilot', [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'averageOrderValue' => $averageOrderValue,
            'topProducts' => $topProducts,
            'recentSales' => $recentSales
        ])->layout('components.layouts.admin');
    }
}
