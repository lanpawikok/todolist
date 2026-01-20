@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
<div class="container">
    <h1 class="mb-4">Add New User</h1>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="is_admin" class="form-label">Role</label>
            <select name="is_admin" class="form-select" required>
                <option value="0" {{ old('is_admin') == 0 ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
@endsection
