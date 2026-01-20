@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <!-- Total Users -->
    <div class="col-xl-3 col-md-6">
        <div class="card text-white bg-primary border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white opacity-75 mb-2">Total Users</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalUsers }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white bg-opacity-10 border-0">
                <a href="{{ route('admin.users.index') }}" class="text-white text-decoration-none small">
                    View Details <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Total Tasks -->
    <div class="col-xl-3 col-md-6">
        <div class="card text-white bg-info border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white opacity-75 mb-2">Total Tasks</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalTasks }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-tasks"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white bg-opacity-10 border-0">
                <a href="{{ route('admin.tasks.index') }}" class="text-white text-decoration-none small">
                    View Details <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Completed Tasks -->
    <div class="col-xl-3 col-md-6">
        <div class="card text-white bg-success border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white opacity-75 mb-2">Completed</h6>
                        <h2 class="mb-0 fw-bold">{{ $completedTasks }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white bg-opacity-10 border-0">
                <small class="text-white">
                    {{ $totalTasks > 0 ? number_format(($completedTasks / $totalTasks) * 100, 1) : 0 }}% Completion Rate
                </small>
            </div>
        </div>
    </div>

    <!-- Pending Tasks -->
    <div class="col-xl-3 col-md-6">
        <div class="card text-white bg-warning border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-dark opacity-75 mb-2">Pending</h6>
                        <h2 class="mb-0 fw-bold text-dark">{{ $pendingTasks }}</h2>
                    </div>
                    <div class="fs-1 opacity-50 text-dark">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white bg-opacity-10 border-0">
                <small class="text-dark">
                    {{ $totalTasks > 0 ? number_format(($pendingTasks / $totalTasks) * 100, 1) : 0 }}% Pending
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-bolt text-warning me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-tasks"></i> Manage Tasks
                    </a>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-success">
                        <i class="fas fa-money-bill-wave"></i> Manage Payments
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-outline-warning">
                        <i class="fas fa-user-plus"></i> Add New User
                    </a>
                    <a href="{{ route('admin.tasks.create') }}" class="btn btn-outline-warning">
                        <i class="fas fa-plus"></i> Create Task
                    </a>
                    <a href="{{ route('admin.dashboard.stats') }}" class="btn btn-outline-dark">
                        <i class="fas fa-chart-line"></i> Performance Stats
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Users & Tasks -->
<div class="row g-4">
    <!-- Recent Users -->
    <div class="col-lg-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-user-friends text-primary me-2"></i>Recent Users</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUsers as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-semibold me-2" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <strong>{{ $user->name }}</strong>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->is_admin)
                                        <span class="badge bg-primary">
                                            <i class="fas fa-crown"></i> Admin
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-user"></i> User
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="far fa-clock"></i> {{ $user->created_at->diffForHumans() }}
                                    </small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    No users found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Tasks -->
    <div class="col-lg-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list-check text-info me-2"></i>Recent Tasks</h5>
                <a href="{{ route('admin.tasks.index') }}" class="btn btn-sm btn-outline-info">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Task</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTasks as $task)
                            <tr>
                                <td>
                                    <strong>{{ Str::limit($task->title, 30) }}</strong>
                                    @if($task->description)
                                        <br><small class="text-muted">{{ Str::limit($task->description, 40) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <small>
                                        <i class="fas fa-user-circle"></i> {{ $task->user->name }}
                                    </small>
                                </td>
                                <td>
                                    @if($task->is_completed)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> Completed
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($task->priority === 'high')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-exclamation-circle"></i> High
                                        </span>
                                    @elseif($task->priority === 'medium')
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-minus-circle"></i> Medium
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-arrow-down"></i> Low
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    No tasks found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection