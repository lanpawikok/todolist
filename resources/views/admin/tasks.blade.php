@extends('layouts.admin')

@section('title', 'Task Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Task Management</h2>
                <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Task
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Due Date</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>
                                    <strong>{{ $task->title }}</strong>
                                    @if($task->description)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($task->user)
                                        <span class="badge bg-info">{{ $task->user->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">Unassigned</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'in_progress' => 'primary',
                                            'completed' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $color = $statusColors[$task->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }}">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $priorityColors = [
                                            'low' => 'success',
                                            'medium' => 'warning',
                                            'high' => 'danger'
                                        ];
                                        $pColor = $priorityColors[$task->priority] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $pColor }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </td>
                                <td>
                                    @if($task->due_date)
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                        @if(\Carbon\Carbon::parse($task->due_date)->isPast() && $task->status != 'completed')
                                            <br><small class="text-danger">Overdue</small>
                                        @endif
                                    @else
                                        <span class="text-muted">No due date</span>
                                    @endif
                                </td>
                                <td>{{ $task->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.tasks.show', $task->id) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.tasks.edit', $task->id) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.tasks.destroy', $task->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this task?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <p class="text-muted mb-0">No tasks found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tasks->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $tasks->links() }}
                </div>
            @endif
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pending Tasks</h5>
                    <h2>{{ $tasks->where('status', 'pending')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">In Progress</h5>
                    <h2>{{ $tasks->where('status', 'in_progress')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Completed</h5>
                    <h2>{{ $tasks->where('status', 'completed')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .btn-group .btn {
        margin: 0;
    }
    
    .card {
        border: none;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush