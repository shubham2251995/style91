<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // Sales Statistics
        $totalRevenue = \App\Models\Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $todayRevenue = \App\Models\Order::whereDate('created_at', today())
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');
        $monthRevenue = \App\Models\Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        // Order Statistics
        $totalOrders = \App\Models\Order::count();
        $pendingOrders = \App\Models\Order::whereIn('status', ['pending', 'processing'])->count();
        $activeOrders = \App\Models\Order::whereIn('status', ['confirmed', 'processing', 'shipped'])->count();
        
        // Recent Orders
        $recentOrders = \App\Models\Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        // Low Stock Products
        $lowStockProducts = \App\Models\Product::where('stock_quantity', '<=', 10)
            ->where('stock_quantity', '>', 0)
            ->orderBy('stock_quantity')
            ->limit(10)
            ->get();

        // Out of Stock
        $outOfStock = \App\Models\Product::where('stock_quantity', 0)->count();

        // Top Products (by orders)
        $topProducts = \App\Models\Product::withCount(['orderItems' => function($query) {
                $query->whereHas('order', function($q) {
                    $q->where('status', '!=', 'cancelled');
                });
            }])
            ->orderBy('order_items_count', 'desc')
            ->limit(5)
            ->get();

        // Customer Statistics
        $totalCustomers = \App\Models\User::where('role', '!=', 'admin')->count();
        $newCustomersToday = \App\Models\User::whereDate('created_at', today())
            ->where('role', '!=', 'admin')
            ->count();

        return view('livewire.admin.dashboard', [
            'totalRevenue' => $totalRevenue,
            'todayRevenue' => $todayRevenue,
            'monthRevenue' => $monthRevenue,
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'activeOrders' => $activeOrders,
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
            'outOfStock' => $outOfStock,
            'topProducts' => $topProducts,
            'totalCustomers' => $totalCustomers,
            'newCustomersToday' => $newCustomersToday,
        ])->layout('components.layouts.admin');
    }
}
