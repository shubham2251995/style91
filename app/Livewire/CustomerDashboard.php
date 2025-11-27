<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class CustomerDashboard extends Component
{
    public $activeTab = 'orders';
    
    // Password change
    public $currentPassword = '';
    public $newPassword = '';
    public $newPassword_confirmation = '';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPasswordFields();
    }

    public function resetPasswordFields()
    {
        $this->currentPassword = '';
        $this->newPassword = '';
        $this->newPassword_confirmation = '';
    }

    public function changePassword()
    {
        $this->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!\Hash::check($this->currentPassword, $user->password)) {
            session()->flash('error', 'Current password is incorrect.');
            return;
        }

        $user->update([
            'password' => \Hash::make($this->newPassword),
        ]);

        $this->resetPasswordFields();
        session()->flash('message', 'Password changed successfully!');

        // Send email notification
        try {
            \Mail::to($user->email)->send(new \App\Mail\PasswordChanged($user));
        } catch (\Exception $e) {
            \Log::error('Failed to send password change email: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $user = Auth::user();
        
        $orders = Order::where('user_id', $user->id)
            ->with('items.product')
            ->latest()
            ->paginate(10);

        $wishlist = Wishlist::where('user_id', $user->id)
            ->with('product')
            ->latest()
            ->get();

        $addresses = Address::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('livewire.customer-dashboard', [
            'orders' => $orders,
            'wishlist' => $wishlist,
            'addresses' => $addresses,
            'user' => $user,
        ]);
    }
}
