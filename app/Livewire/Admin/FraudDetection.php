<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class FraudDetection extends Component
{
    use WithPagination;

    public $filterLevel = '';
    public $stats = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->stats = [
            'total' => DB::table('fraud_logs')->count(),
            'high_risk' => DB::table('fraud_logs')->where('risk_level', 'high')->count(),
            'medium_risk' => DB::table('fraud_logs')->where('risk_level', 'medium')->count(),
            'blocked' => DB::table('fraud_logs')->where('action', 'block')->count(),
            'today' => DB::table('fraud_logs')->whereDate('created_at', today())->count(),
        ];
    }

    public function render()
    {
        $query = DB::table('fraud_logs')
            ->leftJoin('orders', 'fraud_logs.order_id', '=', 'orders.id')
            ->leftJoin('users', 'fraud_logs.user_id', '=', 'users.id')
            ->select('fraud_logs.*', 'orders.id as order_number', 'users.name as user_name', 'users.email as user_email')
            ->orderBy('fraud_logs.created_at', 'desc');

        if ($this->filterLevel) {
            $query->where('fraud_logs.risk_level', $this->filterLevel);
        }

        $logs = $query->paginate(20);

        return view('livewire.admin.fraud-detection', [
            'logs' => $logs,
        ]);
    }
}
