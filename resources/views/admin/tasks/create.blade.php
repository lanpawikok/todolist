@extends('layouts.admin')

@section('title', 'Create Task')

@section('content')
<div class="container">
    <h1 class="mb-4">Create New Task</h1>

    <form action="{{ route('admin.tasks.store') }}" method="POST">
        @csrf

        {{-- Title --}}
        <div class="mb-3">
            <label for="title" class="form-label">Task Title</label>
            <input type="text" class="form-control" name="title" id="title"
                value="{{ old('title') }}" required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Task Description</label>
            <textarea class="form-control" name="description" id="description" rows="4">{{ old('description') }}</textarea>
        </div>

        {{-- Assign to user --}}
        <div class="mb-3">
            <label for="user_id" class="form-label">Assign To</label>
            <select id="user_id" name="user_id" class="form-select" required>
                <option value="">-- Select User --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Priority --}}
        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select id="priority" name="priority" class="form-select" required>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>

        {{-- Due Date --}}
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" class="form-control" name="due_date" id="due_date"
                value="{{ old('due_date') }}">
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
