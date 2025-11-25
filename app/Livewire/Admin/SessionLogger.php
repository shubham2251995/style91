<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UserSession;

class SessionLogger extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.session-logger', [
            'sessions' => UserSession::with('user', 'events')
                ->latest('started_at')
                ->paginate(20)
        ])->layout('components.layouts.admin');
    }
}
