<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks - ToDoList</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="#">
                <i class="fas fa-check-circle"></i> ToDoList
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('tasks.index') }}">
                            <i class="fas fa-list"></i> My Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('balance.index') }}">
                            <i class="fas fa-wallet"></i> Balance
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user"></i> Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tasks.trash') }}">
                            <i class="fas fa-trash"></i> Trash
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-warning text-dark fs-6">
                        <i class="fas fa-wallet"></i> {{ Auth::user()->formatted_balance }}
                    </span>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ url('/profile') }}" class="text-decoration-none">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                @endif
                            </div>
                        </a>
                        <div class="d-none d-lg-block">
                            <div class="fw-semibold small">{{ Auth::user()->name }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h1 class="h3 fw-bold text-primary mb-0">
                <i class="fas fa-clipboard-list"></i> My Tasks
            </h1>
            <div class="d-flex gap-2">
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Task
                </a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ url('/admin/dashboard') }}" class="btn btn-warning">
                        <i class="fas fa-user-shield"></i> Admin
                    </a>
                @endif
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                                <small>Total Tasks</small>
                            </div>
                            <i class="fas fa-list-check fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold mb-0">{{ $stats['pending'] }}</h3>
                                <small>Pending</small>
                            </div>
                            <i class="fas fa-clock fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold mb-0">{{ $stats['in_progress'] }}</h3>
                                <small>In Progress</small>
                            </div>
                            <i class="fas fa-spinner fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold mb-0">{{ $stats['completed'] }}</h3>
                                <small>Completed</small>
                            </div>
                            <i class="fas fa-check-circle fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <ul class="nav nav-pills mb-4 flex-wrap gap-2">
            <li class="nav-item">
                <a class="nav-link {{ !request('status') && !request('priority') ? 'active' : '' }}" href="{{ route('tasks.index') }}">
                    <i class="fas fa-border-all"></i> All
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('tasks.index', ['status' => 'pending']) }}">
                    <i class="fas fa-clock"></i> Pending
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'in_progress' ? 'active' : '' }}" href="{{ route('tasks.index', ['status' => 'in_progress']) }}">
                    <i class="fas fa-spinner"></i> In Progress
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}" href="{{ route('tasks.index', ['status' => 'completed']) }}">
                    <i class="fas fa-check-circle"></i> Completed
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('priority') == 'high' ? 'active' : '' }}" href="{{ route('tasks.index', ['priority' => 'high']) }}">
                    <i class="fas fa-flag"></i> High Priority
                </a>
            </li>
        </ul>

        <!-- Tasks List -->
        @if($tasks->count() > 0)
            <div class="row g-3">
                @foreach($tasks as $task)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm {{ $task->status == 'completed' ? 'bg-light' : '' }}">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                            @csrf
                                            <input type="checkbox" class="form-check-input" style="width: 1.5rem; height: 1.5rem;" 
                                                   {{ $task->status == 'completed' ? 'checked' : '' }}
                                                   onchange="this.form.submit()">
                                        </form>
                                    </div>
                                    <div class="col">
                                        <h5 class="mb-2 {{ $task->status == 'completed' ? 'text-decoration-line-through text-muted' : 'fw-semibold' }}">
                                            {{ $task->title }}
                                        </h5>
                                        @if($task->description)
                                            <p class="text-muted small mb-2">{{ Str::limit($task->description, 120) }}</p>
                                        @endif
                                        <div class="d-flex gap-2 flex-wrap">
                                            <span class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'success') }}">
                                                <i class="fas fa-flag"></i> {{ ucfirst($task->priority) }}
                                            </span>
                                            <span class="badge bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'info' : 'secondary') }}">
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                            @if($task->due_date)
                                                <span class="badge bg-light text-dark">
                                                    <i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Delete this task?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $tasks->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-clipboard-list fa-5x text-muted mb-3"></i>
                <h3 class="text-muted">No Tasks Found</h3>
                <p class="text-muted mb-4">Start by creating your first task!</p>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create Task
                </a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>