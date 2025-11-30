<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserManager extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';
    public $showModal = false;
    public $showDetailsModal = false;
    public $editMode = false;

    // User fields
    public $userId;
    public $name;
    public $email;
    public $mobile;
    public $password;
    public $role = 'customer';
    public $is_active = true;

    // Selected user for details
    public $selectedUser;

    protected $queryString = ['search', 'roleFilter', 'statusFilter'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'mobile' => 'nullable|string|max:15',
        'password' => 'required|min:8',
        'role' => 'required|in:customer,admin',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['userId', 'name', 'email', 'mobile', 'password', 'role']);
        $this->is_active = true;
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->mobile = $user->mobile;
        $this->role = $user->role ?? 'customer';
        $this->is_active = $user->is_active ?? true;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->editMode) {
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $this->userId,
                'mobile' => 'nullable|string|max:15',
                'role' => 'required|in:customer,admin',
            ]);

            $user = User::findOrFail($this->userId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'role' => $this->role,
                'is_active' => $this->is_active,
            ]);

            if ($this->password) {
                $user->update(['password' => Hash::make($this->password)]);
            }

            session()->flash('message', 'User updated successfully.');
        } else {
            $this->validate();

            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'password' => Hash::make($this->password),
                'role' => $this->role,
                'is_active' => $this->is_active,
            ]);

            session()->flash('message', 'User created successfully.');
        }

        $this->showModal = false;
        $this->reset(['userId', 'name', 'email', 'mobile', 'password']);
    }

    public function viewDetails($id)
    {
        $this->selectedUser = User::with(['orders', 'addresses'])
                                   ->withCount('orders')
                                   ->findOrFail($id);
        $this->showDetailsModal = true;
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);
        
        session()->flash('message', 'User status updated.');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Cannot delete your own account.');
            return;
        }

        // Prevent deleting the last admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            session()->flash('error', 'Cannot delete the last admin user.');
            return;
        }

        $user->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function impersonate($id)
    {
        $user = User::findOrFail($id);
        
        // Store original user in session
        session(['impersonate_from' => auth()->id()]);
        auth()->login($user);
        
        return redirect()->route('home');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('mobile', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function($query) {
                $query->where('role', $this->roleFilter);
            })
            ->when($this->statusFilter !== '', function($query) {
                $query->where('is_active', $this->statusFilter);
            })
            ->withCount('orders')
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'customers' => User::where('role', 'customer')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'new_today' => User::whereDate('created_at', today())->count(),
            'new_this_week' => User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        return view('livewire.admin.user-manager', [
            'users' => $users,
            'stats' => $stats
        ])->layout('components.layouts.admin');
    }
}
