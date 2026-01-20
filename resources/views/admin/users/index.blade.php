@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2 class="mb-3"><i class="fas fa-users"></i> User Management</h2>
        
        <!-- Search & Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.users.index') }}" method="GET">
                    <div class="row g-3">
                        <!-- Search -->
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <!-- Role Filter -->
                        <div class="col-md-4">
                            <select name="role" class="form-select">
                                <option value="">All Roles</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>
                        
                        <!-- Buttons -->
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Users ({{ $users->total() }})</h5>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-user-plus"></i> Add User
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">User</th>
                                <th width="25%">Email</th>
                                <th width="10%">Role</th>
                                <th width="10%">Tasks</th>
                                <th width="15%">Joined</th>
                                <th width="10%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-2">
                                            @if(isset($user->avatar) && $user->avatar)
                                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar">
                                            @else
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <strong>{{ $user->name }}</strong>
                                            @if($user->id === auth()->id())
                                                <span class="badge bg-info ms-2">You</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->is_admin)
                                        <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            <i class="fas fa-crown"></i> Admin
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-user"></i> User
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $user->tasks()->count() }} tasks
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="far fa-clock"></i> {{ $user->created_at->diffForHumans() }}
                                        <br>
                                        <span class="text-muted">{{ $user->created_at->format('M d, Y') }}</span>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure? This will also delete all tasks of this user.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @else
                                        <button class="btn btn-secondary" disabled title="Cannot delete yourself">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-users-slash fa-3x text-muted mb-3 d-block"></i>
                                    <h5 class="text-muted">No users found</h5>
                                    <p class="text-muted">Try adjusting your filters.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($users->hasPages())
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                    </div>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
    }
    
    .user-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
@endpush
@endsection