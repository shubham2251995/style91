<div class="space-y-6" wire:poll.5s="$refresh">
    {{-- Success/Error Messages --}}
    @if(session()->has('message'))
        <div class="bg-green-500/10 border border-green-500/50 rounded-xl p-4 flex items-center gap-3">
            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-green-400 font-medium">{{ session('message') }}</span>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="bg-red-500/10 border border-red-500/50 rounded-xl p-4 flex items-center gap-3">
            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-red-400 font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">User Management</h2>
            <p class="text-gray-400 mt-1">Manage user accounts, roles, and permissions</p>
        </div>
        <button wire:click="create" class="px-4 py-2 bg-brand-accent text-black rounded-lg font-bold hover:bg-blue-500 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create User
        </button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
        <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/5 border border-blue-500/20 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-400 text-sm font-medium">Total Users</p>
                    <p class="text-2xl font-bold mt-1">{{ number_format($stats['total']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500/10 to-green-600/5 border border-green-500/20 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-400 text-sm font-medium">Active Users</p>
                    <p class="text-2xl font-bold mt-1">{{ number_format($stats['active']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500/10 to-purple-600/5 border border-purple-500/20 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-400 text-sm font-medium">Customers</p>
                    <p class="text-2xl font-bold mt-1">{{ number_format($stats['customers']) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500/10 to-orange-600/5 border border-orange-500/20 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-400 text-sm font-medium">Admins</p>
                    <p class="text-2xl font-bold mt-1">{{ number_format($stats['admins']) }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-cyan-500/10 to-cyan-600/5 border border-cyan-500/20 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-cyan-400 text-sm font-medium">New Today</p>
                    <p class="text-2xl font-bold mt-1">{{ number_format($stats['new_today']) }}</p>
                </div>
                <div class="w-12 h-12 bg-cyan-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-pink-500/10 to-pink-600/5 border border-pink-500/20 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-pink-400 text-sm font-medium">This Week</p>
                    <p class="text-2xl font-bold mt-1">{{ number_format($stats['new_this_week']) }}</p>
                </div>
                <div class="w-12 h-12 bg-pink-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-pink-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white/5 border border-white/10 rounded-xl p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Search</label>
                <input type="text" wire:model.live="search" 
                       class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent"
                       placeholder="Name, email, or phone...">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Role</label>
                <select wire:model.live="roleFilter" class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-2 text-white focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
                    <option value="">All Roles</option>
                    <option value="customer">Customer</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Status</label>
                <select wire:model.live="statusFilter" class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-2 text-white focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <div class="flex items-end">
                <button wire:click="$set('search', '')" class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition">
                    Clear Filters
                </button>
            </div>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-accent uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-accent uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-accent uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-accent uppercase tracking-wider">Orders</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-accent uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-accent uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-brand-accent uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($users as $user)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-brand-accent/20 rounded-full flex items-center justify-center font-bold text-brand-accent">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-medium">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-400">ID: #{{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div>{{ $user->email }}</div>
                                @if($user->mobile)
                                <div class="text-gray-400">{{ $user->mobile }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $user->role === 'admin' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/50' : 'bg-blue-500/20 text-blue-400 border border-blue-500/50' }}">
                                {{ ucfirst($user->role ?? 'customer') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm">{{ $user->orders_count ?? 0 }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="toggleStatus({{ $user->id }})" 
                                    class="px-3 py-1 rounded-full text-xs font-bold transition {{ $user->is_active ? 'bg-green-500/20 text-green-400 border border-green-500/50 hover:bg-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/50 hover:bg-red-500/30' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="viewDetails({{ $user->id }})" 
                                        class="p-2 text-blue-400 hover:bg-blue-500/20 rounded-lg transition" title="View Details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button wire:click="edit({{ $user->id }})" 
                                        class="p-2 text-yellow-400 hover:bg-yellow-500/20 rounded-lg transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                @if($user->id !== auth()->id())
                                <button wire:click="delete({{ $user->id }})" 
                                        wire:confirm="Are you sure you want to delete this user?"
                                        class="p-2 text-red-400 hover:bg-red-500/20 rounded-lg transition" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                            <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <p class="mt-4 text-lg">No users found</p>
                            <p class="text-sm">Try adjusting your filters or create a new user</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-white/10">
            {{ $users->links() }}
        </div>
    </div>

    {{-- Create/Edit Modal --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-900/75" wire:click="$set('showModal', false)"></div>
            
            <div class="inline-block align-bottom bg-gray-800 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-brand-accent/30">
                <form wire:submit.prevent="save">
                    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4 border-b border-white/10">
                        <h3 class="text-xl font-bold">{{ $editMode ? 'Edit User' : 'Create New User' }}</h3>
                    </div>

                    <div class="bg-gray-800 px-6 py-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Name *</label>
                            <input type="text" wire:model="name" required
                                   class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
                            @error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Email *</label>
                            <input type="email" wire:model="email" required
                                   class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
                            @error('email') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Mobile</label>
                            <input type="text" wire:model="mobile"
                                   class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
                            @error('mobile') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Password {{ $editMode ? '(leave blank to keep current)' : '*' }}</label>
                            <input type="password" wire:model="password" {{ !$editMode ? 'required' : '' }}
                                   class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
                            @error('password') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Role *</label>
                            <select wire:model="role" required
                                    class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-2 text-white focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
                                <option value="customer">Customer</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" wire:model="is_active" id="is_active" class="w-4 h-4 text-brand-accent bg-black/30 border-white/10 rounded focus:ring-brand-accent">
                            <label for="is_active" class="ml-2 text-sm text-gray-300">Active</label>
                        </div>
                    </div>

                    <div class="bg-gray-900 px-6 py-4 flex justify-end gap-3">
                        <button type="button" wire:click="$set('showModal', false)" 
                                class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-brand-accent text-black rounded-lg font-bold hover:bg-blue-500 transition">
                            {{ $editMode ? 'Update User' : 'Create User' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Details Modal --}}
    @if($showDetailsModal && $selectedUser)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-900/75" wire:click="$set('showDetailsModal', false)"></div>
            
            <div class="inline-block align-bottom bg-gray-800 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-brand-accent/30">
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4 border-b border-white/10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-brand-accent/20 rounded-full flex items-center justify-center font-bold text-brand-accent text-xl">
                                {{ strtoupper(substr($selectedUser->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">{{ $selectedUser->name }}</h3>
                                <p class="text-sm text-gray-400">{{ $selectedUser->email }}</p>
                            </div>
                        </div>
                        <button wire:click="$set('showDetailsModal', false)" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="bg-gray-800 px-6 py-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-400">User ID</p>
                            <p class="font-medium">#{{ $selectedUser->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Role</p>
                            <p class="font-medium">{{ ucfirst($selectedUser->role ?? 'customer') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Mobile</p>
                            <p class="font-medium">{{ $selectedUser->mobile ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Status</p>
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $selectedUser->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                {{ $selectedUser->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Total Orders</p>
                            <p class="font-medium">{{ $selectedUser->orders_count }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Member Since</p>
                            <p class="font-medium">{{ $selectedUser->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-900 px-6 py-4 flex justify-end gap-3">
                    <button wire:click="impersonate({{ $selectedUser->id }})" 
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                        🔐 Impersonate User
                    </button>
                    <button wire:click="$set('showDetailsModal', false)" 
                            class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
