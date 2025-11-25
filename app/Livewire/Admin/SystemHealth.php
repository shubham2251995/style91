<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;

class SystemHealth extends Component
{
    public $dbStatus = 'checking';
    public $cacheStatus = 'checking';
    public $queueSize = 0;

    public function mount()
    {
        $this->checkHealth();
    }

    public function checkHealth()
    {
        // Check Database
        try {
            DB::connection()->getPdo();
            $this->dbStatus = 'online';
        } catch (\Exception $e) {
            $this->dbStatus = 'offline';
        }

        // Check Cache
        try {
            Cache::put('health_check', 'ok', 10);
            if (Cache::get('health_check') === 'ok') {
                $this->cacheStatus = 'online';
            } else {
                $this->cacheStatus = 'issue';
            }
        } catch (\Exception $e) {
            $this->cacheStatus = 'offline';
        }

        // Check Queue (Database driver)
        try {
            $this->queueSize = DB::table('jobs')->count();
        } catch (\Exception $e) {
            $this->queueSize = 'N/A';
        }
    }

    public function render()
    {
        return view('livewire.admin.system-health');
    }
}
