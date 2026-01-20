@extends('layouts.admin')

@section('title', 'Manage Tasks')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2 class="mb-3"><i class="fas fa-tasks"></i> Task Management</h2>
        
        <!-- Search & Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.tasks.index') }}" method="GET">
                    <div class="row g-3">
                        <!-- Search -->
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="Search tasks or users..." value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <!-- Status Filter -->
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        
                        <!-- Priority Filter -->
                        <div class="col-md-3">
                            <select name="priority" class="form-select">
                                <option value="">All Priority</option>
                                <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                                <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
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

        <!-- Tasks Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Tasks ({{ $tasks->total() }})</h5>
                <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Create Task
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Task</th>
                                <th width="15%">User</th>
                                <th width="10%">Status</th>
                                <th width="10%">Priority</th>
                                <th width="15%">Due Date</th>
                                <th width="10%">Created</th>
                                <th width="10%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>
                                    <strong>{{ $task->title }}</strong>
                                    @if($task->description)
                                        <br><small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-2" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                            {{ strtoupper(substr($task->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $task->user->name }}</div>
                                            <small class="text-muted">{{ $task->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ route('admin.tasks.toggle', $task->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $task->is_completed ? 'btn-success' : 'btn-warning' }} border-0">
                                            @if($task->is_completed)
                                                <i class="fas fa-check"></i> Completed
                                            @else
                                                <i class="fas fa-clock"></i> Pending
                                            @endif
                                        </button>
                                    </form>
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
                                <td>
                                    @if($task->due_date)
                                        <small>
                                            <i class="far fa-calendar"></i> 
                                            {{ $task->due_date->format('M d, Y') }}
                                            @if($task->due_date->isPast() && !$task->is_completed)
                                                <br><span class="badge bg-danger">Overdue</span>
                                            @endif
                                        </small>
                                    @else
                                        <small class="text-muted">No due date</small>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $task->created_at->diffForHumans() }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.tasks.show', $task->id) }}" class="btn btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this task?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>   
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                    <h5 class="text-muted">Tidak ada Tugas</h5>
                                    <p class="text-muted">Coba sesuaikan filter kamu atau buat tugas baru</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($tasks->hasPages())
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} tasks
                    </div>
                    <div>
                        {{ $tasks->links() }}
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
</style>
@endpush
@endsection