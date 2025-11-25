<?php

namespace App\Livewire\Squad;

use Livewire\Component;
use App\Models\Product;
use App\Models\Squad;
use App\Models\SquadMember;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Widget extends Component
{
    public Product $product;
    public $squadCode = '';
    public $activeSquad = null;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->checkActiveSquad();
    }

    public function checkActiveSquad()
    {
        if (Auth::check()) {
            $this->activeSquad = Squad::where('product_id', $this->product->id)
                ->whereHas('members', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->with('members.user')
                ->first();
        }
    }

    public function createSquad()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $code = strtoupper(Str::random(6));
        
        $squad = Squad::create([
            'code' => $code,
            'product_id' => $this->product->id,
            'leader_id' => Auth::id(),
            'target_size' => 3, // Default target
            'current_size' => 1,
            'expires_at' => now()->addHours(24),
        ]);

        SquadMember::create([
            'squad_id' => $squad->id,
            'user_id' => Auth::id(),
            'status' => 'joined'
        ]);

        $this->activeSquad = $squad;
    }

    public function joinSquad()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $squad = Squad::where('code', $this->squadCode)
            ->where('product_id', $this->product->id)
            ->where('status', 'open')
            ->first();

        if (!$squad) {
            $this->addError('squadCode', 'Invalid or expired squad code.');
            return;
        }

        if ($squad->current_size >= $squad->target_size) {
            $this->addError('squadCode', 'Squad is full.');
            return;
        }

        // Check if already in squad
        if ($squad->members()->where('user_id', Auth::id())->exists()) {
            return;
        }

        SquadMember::create([
            'squad_id' => $squad->id,
            'user_id' => Auth::id(),
            'status' => 'joined'
        ]);

        $squad->increment('current_size');
        
        if ($squad->current_size >= $squad->target_size) {
            $squad->update(['status' => 'completed']);
            // Trigger discount logic here (future)
        }

        $this->activeSquad = $squad->fresh(['members.user']);
        $this->squadCode = '';
    }

    public function render()
    {
        return view('livewire.squad.widget');
    }
}
