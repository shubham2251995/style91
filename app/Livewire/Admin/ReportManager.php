<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class ReportManager extends Component
{
    public $reportType = 'sales';
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    public function generateReport()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        switch ($this->reportType) {
            case 'sales':
                return $this->generateSalesReport();
            case 'products':
                return $this->generateProductReport();
            case 'customers':
                return $this->generateCustomerReport();
        }
    }

    private function generateSalesReport()
    {
        $orders = Order::with('user')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();

        $csv = "Order ID,Customer,Email,Date,Total,Status\n";
        foreach ($orders as $order) {
            $csv .= sprintf(
                "%d,%s,%s,%s,%.2f,%s\n",
                $order->id,
                $order->user->name ?? 'Guest',
                $order->user->email ?? 'N/A',
                $order->created_at->format('Y-m-d H:i'),
                $order->total_amount,
                $order->status
            );
        }

        return Response::streamDownload(function() use ($csv) {
            echo $csv;
        }, 'sales_report_' . now()->format('Y-m-d') . '.csv');
    }

    private function generateProductReport()
    {
        $products = OrderItem::with('product')
            ->whereHas('order', function($q) {
                $q->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->selectRaw('product_id, SUM(quantity) as total_sold, SUM(price * quantity) as revenue')
            ->groupBy('product_id')
            ->get();

        $csv = "Product,Units Sold,Revenue\n";
        foreach ($products as $item) {
            $csv .= sprintf(
                "%s,%d,%.2f\n",
                $item->product->name ?? 'Unknown',
                $item->total_sold,
                $item->revenue
            );
        }

        return Response::streamDownload(function() use ($csv) {
            echo $csv;
        }, 'product_report_' . now()->format('Y-m-d') . '.csv');
    }

    private function generateCustomerReport()
    {
        $customers = User::withCount('orders')
            ->withSum('orders', 'total_amount')
            ->having('orders_count', '>', 0)
            ->get();

        $csv = "Customer,Email,Total Orders,Total Spent\n";
        foreach ($customers as $customer) {
            $csv .= sprintf(
                "%s,%s,%d,%.2f\n",
                $customer->name,
                $customer->email,
                $customer->orders_count,
                $customer->orders_sum_total_amount ?? 0
            );
        }

        return Response::streamDownload(function() use ($csv) {
            echo $csv;
        }, 'customer_report_' . now()->format('Y-m-d') . '.csv');
    }

    public function render()
    {
        return view('livewire.admin.report-manager');
    }
}
