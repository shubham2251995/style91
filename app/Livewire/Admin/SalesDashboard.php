<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SalesDashboard extends Component
{
    public $dateRange = 'today';
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->setDateRange();
    }

    public function updatedDateRange()
    {
        $this->setDateRange();
    }

    private function setDateRange()
    {
        switch ($this->dateRange) {
            case 'today':
                $this->startDate = now()->startOfDay();
                $this->endDate = now()->endOfDay();
                break;
            case 'week':
                $this->startDate = now()->startOfWeek();
                $this->endDate = now()->endOfWeek();
                break;
            case 'month':
                $this->startDate = now()->startOfMonth();
                $this->endDate = now()->endOfMonth();
                break;
            case 'year':
                $this->startDate = now()->startOfYear();
                $this->endDate = now()->endOfYear();
                break;
        }
    }

    public function render()
    {
        $orders = Order::whereBetween('created_at', [$this->startDate, $this->endDate]);
        
        $totalRevenue = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Top selling products
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('order', function($q) {
                $q->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->with('product')
            ->get();

        // Daily sales for chart
        $dailySales = Order::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('livewire.admin.sales-dashboard', [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'avgOrderValue' => $avgOrderValue,
            'topProducts' => $topProducts,
            'dailySales' => $dailySales,
        ]);
    }
}
