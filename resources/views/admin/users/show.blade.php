@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<div class="container">
    <h1 class="mb-4">Detail User</h1>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Informasi User</strong>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $user->id }}</p>
            <p><strong>Nama:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Dibuat pada:</strong> {{ $user->created_at }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Daftar Tugas</strong>
        </div>
        <div class="card-body">
            @if($tasks->count() > 0)
                <ul class="list-group">
                    @foreach ($tasks as $task)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $task->title }}</span>
                            <span class="badge bg-{{ $task->is_completed ? 'success' : 'warning' }}">
                                {{ $task->is_completed ? 'Completed' : 'Pending' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">User ini belum memiliki task.</p>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
