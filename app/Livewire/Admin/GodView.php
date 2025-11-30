<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class GodView extends Component
{
    public $refreshInterval = 5000; // 5 seconds
    public $selectedPeriod = '24h';

    public function getRealtimeMetrics()
    {
        return [
            'active_users' => $this->getActiveUsersCount(),
            'cart_value' => $this->getLiveCartsValue(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'revenue_today' => Order::whereDate('created_at', today())
                                    ->where('status', 'completed')
                                    ->sum('total'),
        ];
    }

    protected function getActiveUsersCount()
    {
        // Users active in last 15 minutes
        return DB::table('sessions')
                 ->where('last_activity', '>', now()->subMinutes(15)->timestamp)
                 ->count();
    }

    protected function getLiveCartsValue()
    {
        return DB::table('cart_items')
                 ->join('products', 'cart_items.product_id', '=', 'products.id')
                 ->sum(DB::raw('cart_items.quantity * products.price'));
    }

    public function render()
    {
        $timeRange = match($this->selectedPeriod) {
            '1h' => now()->subHour(),
            '24h' => now()->subDay(),
            '7d' => now()->subDays(7),
            '30d' => now()->subDays(30),
            default => now()->subDay(),
        };

        // Quick Stats
        $stats = [
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total'),
            'avg_order_value' => Order::where('status', 'completed')->avg('total'),
            'conversion_rate' => $this->calculateConversionRate(),
        ];

        // Recent Activity
        $recentOrders = Order::with('user')
                             ->latest()
                             ->take(10)
                             ->get();

        $recentUsers = User::latest()
                          ->take(10)
                          ->get();

        // Top Products
        $topProducts = DB::table('order_items')
                        ->select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(price * quantity) as revenue'))
                        ->join('products', 'order_items.product_id', '=', 'products.id')
                        ->where('order_items.created_at', '>=', $timeRange)
                        ->groupBy('product_id')
                        ->orderByDesc('total_sold')
                        ->take(5)
                        ->get();

        // System Health
        $systemHealth = [
            'database' => $this->checkDatabaseHealth(),
            'storage' => $this->checkStorageHealth(),
            'cache' => $this->checkCacheHealth(),
            'queue' => $this->checkQueueHealth(),
        ];

        // Revenue Chart Data (last 7 days)
        $revenueChart = $this->getRevenueChartData();

        // Geographic Distribution
        $usersByCountry = User::select('country', DB::raw('count(*) as count'))
                              ->whereNotNull('country')
                              ->groupBy('country')
                              ->orderByDesc('count')
                              ->take(10)
                              ->get();

        return view('livewire.admin.god-view', [
            'stats' => $stats,
            'realtimeMetrics' => $this->getRealtimeMetrics(),
            'recentOrders' => $recentOrders,
            'recentUsers' => $recentUsers,
            'topProducts' => $topProducts,
            'systemHealth' => $systemHealth,
            'revenueChart' => $revenueChart,
            'usersByCountry' => $usersByCountry,
        ])->layout('components.layouts.admin');
    }

    protected function calculateConversionRate()
    {
        $visitors = DB::table('sessions')->distinct('ip_address')->count('ip_address');
        $orders = Order::count();
        
        return $visitors > 0 ? round(($orders / $visitors) * 100, 2) : 0;
    }

    protected function checkDatabaseHealth()
    {
        try {
            DB::connection()->getPdo();
            return ['status' => 'healthy', 'message' => 'Connected'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    protected function checkStorageHealth()
    {
        $total = disk_total_space(storage_path());
        $free = disk_free_space(storage_path());
        $used = $total - $free;
        $usedPercent = round(($used / $total) * 100, 2);

        return [
            'status' => $usedPercent > 90 ? 'warning' : 'healthy',
            'used' => $this->formatBytes($used),
            'total' => $this->formatBytes($total),
            'percent' => $usedPercent,
        ];
    }

    protected function checkCacheHealth()
    {
        try {
            Cache::put('health_check', true, 10);
            $check = Cache::get('health_check');
            return ['status' => $check ? 'healthy' : 'warning', 'message' => 'Operational'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    protected function checkQueueHealth()
    {
        // Simple check - can be enhanced based on queue driver
        return ['status' => 'healthy', 'message' => 'Operational'];
    }

    protected function getRevenueChartData()
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenue = Order::whereDate('created_at', $date)
                           ->where('status', 'completed')
                           ->sum('total');
            
            $data[] = [
                'date' => $date->format('M d'),
                'revenue' => $revenue,
            ];
        }
        return $data;
    }

    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
