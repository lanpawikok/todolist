<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycle Bin - ToDoList</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold text-danger mb-0">
                <i class="fas fa-trash-restore"></i> Recycle Bin
            </span>
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="d-none d-md-block">
                    <div class="fw-semibold small">{{ Auth::user()->name }}</div>
                    <div class="text-muted" style="font-size: 0.75rem;">{{ Auth::user()->email }}</div>
                </div>
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold text-danger mb-0">
                <i class="fas fa-trash-restore"></i> Recycle Bin
            </h1>
            <a href="{{ route('tasks.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Tasks
            </a>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Info Box -->
        <div class="alert alert-warning border-0 border-start border-warning border-4 mb-4" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Info:</strong> Deleted tasks are stored here. You can restore or permanently delete them.
        </div>

        <!-- Tasks List -->
        @if($tasks->count() > 0)
            <div class="row g-3">
                @foreach($tasks as $task)
                    <div class="col-12">
                        <div class="card border-danger border-start border-4 shadow-sm bg-light">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="fas fa-trash text-danger fa-2x"></i>
                                    </div>
                                    <div class="col">
                                        <h5 class="fw-semibold mb-2">{{ $task->title }}</h5>
                                        @if($task->description)
                                            <p class="text-muted small mb-2">{{ Str::limit($task->description, 120) }}</p>
                                        @endif
                                        <div class="d-flex gap-2 flex-wrap">
                                            <span class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'success') }}">
                                                <i class="fas fa-flag"></i> {{ ucfirst($task->priority) }} Priority
                                            </span>
                                            <span class="badge bg-secondary">
                                                <i class="far fa-trash-alt"></i> Deleted: {{ $task->deleted_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex gap-2 flex-wrap">
                                            <form action="{{ route('tasks.restore', $task->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-undo"></i> Restore
                                                </button>
                                            </form>
                                            <form action="{{ route('tasks.forceDelete', $task->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Permanently delete? Task cannot be recovered!')">
                                                    <i class="fas fa-times"></i> Delete Forever
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
            <!-- Empty State -->
            <div class="text-center py-5">
                <i class="fas fa-trash-alt fa-5x text-muted mb-3"></i>
                <h3 class="text-muted">Recycle Bin is Empty</h3>
                <p class="text-muted mb-4">No deleted tasks</p>
                <a href="{{ route('tasks.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Back to Tasks
                </a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>