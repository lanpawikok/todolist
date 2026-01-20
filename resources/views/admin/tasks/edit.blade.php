@extends('layouts.admin')

@section('title', 'Edit Task')

@section('content')
<div class="container">
    <h1>Edit Task</h1>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $task->title) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="assigned_to" class="form-label">Assign To</label>
            <select class="form-select" id="assigned_to" name="assigned_to">
                <option value="">-- Tidak ada --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select class="form-select" id="priority" name="priority">
                <option value="">-- Tidak ada --</option>
                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Update Task</button>
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
