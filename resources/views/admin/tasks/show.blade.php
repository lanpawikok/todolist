@extends('layouts.admin')

@section('title', 'Edit Task')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Edit Task</h2>
                <div>
                    <a href="{{ route('admin.tasks.show', $task->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> View
                    </a>
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Task Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $task->title) }}"
                                   placeholder="Enter task title"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="5"
                                      placeholder="Enter task description">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label">Assign To</label>
                                <select class="form-select @error('user_id') is-invalid @enderror" 
                                        id="user_id" 
                                        name="user_id">
                                    <option value="">-- Select User --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" 
                                            {{ old('user_id', $task->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty for unassigned task</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" 
                                       class="form-control @error('due_date') is-invalid @enderror" 
                                       id="due_date" 
                                       name="due_date"
                                       value="{{ old('due_date', $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}">
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status"
                                        required>
                                    <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status', $task->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                <select class="form-select @error('priority') is-invalid @enderror" 
                                        id="priority" 
                                        name="priority"
                                        required>
                                    <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-clock"></i> Task Timeline</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Created</small>
                        <div>{{ $task->created_at->format('d M Y, H:i') }}</div>
                        <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>
                    </div>
                    <hr>
                    <div class="mb-2">
                        <small class="text-muted">Last Updated</small>
                        <div>{{ $task->updated_at->format('d M Y, H:i') }}</div>
                        <small class="text-muted">{{ $task->updated_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle"></i> Information</h6>
                </div>
                <div class="card-body">
                    <h6>Task Priority Levels:</h6>
                    <ul class="small">
                        <li><span class="badge bg-success">Low</span> - Can be completed later</li>
                        <li><span class="badge bg-warning">Medium</span> - Normal priority</li>
                        <li><span class="badge bg-danger">High</span> - Urgent task</li>
                    </ul>

                    <hr>

                    <h6>Task Status:</h6>
                    <ul class="small">
                        <li><span class="badge bg-warning">Pending</span> - Not started yet</li>
                        <li><span class="badge bg-primary">In Progress</span> - Currently working</li>
                        <li><span class="badge bg-success">Completed</span> - Finished</li>
                        <li><span class="badge bg-danger">Cancelled</span> - Task cancelled</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
    }
    
    .form-label {
        font-weight: 600;
    }
</style>
@endpush