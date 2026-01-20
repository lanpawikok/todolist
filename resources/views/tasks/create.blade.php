<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task - ToDoList</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .priority-card {
            cursor: pointer;
            transition: all 0.3s;
        }
        .priority-card:hover {
            transform: translateY(-5px);
        }
        .priority-card input[type="radio"] {
            display: none;
        }
        .priority-card input[type="radio"]:checked + .card {
            border-width: 3px;
            border-color: #0d6efd;
            background-color: #e7f1ff;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold text-primary mb-0">
                <i class="fas fa-check-circle"></i> ToDoList
            </span>
            <a href="{{ url('/tasks') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="text-center mb-5">
                    <div class="text-primary mb-3">
                        <i class="fas fa-plus-circle fa-4x"></i>
                    </div>
                    <h1 class="h2 fw-bold mb-2">Create New Task</h1>
                    <p class="text-muted">Add a new task to stay organized and productive</p>
                </div>

                <!-- Form -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ url('/tasks') }}" method="POST" id="createTaskForm">
                            @csrf

                            <!-- Task Details Section -->
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-3 pb-2 border-bottom">
                                    <i class="fas fa-clipboard text-primary me-2"></i>Task Details
                                </h5>

                                <div class="mb-3">
                                    <label for="title" class="form-label fw-medium">
                                        Task Title <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title') }}" 
                                           placeholder="e.g., Complete project proposal"
                                           maxlength="255"
                                           required>
                                    <div class="form-text text-end">
                                        <small><span id="titleCounter">0</span> / 255 characters</small>
                                    </div>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-0">
                                    <label for="description" class="form-label fw-medium">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="5"
                                              placeholder="Add more details about this task... (optional)">{{ old('description') }}</textarea>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle"></i> Add any additional information or notes
                                    </div>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Priority & Schedule Section -->
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-3 pb-2 border-bottom">
                                    <i class="fas fa-sliders-h text-primary me-2"></i>Priority & Schedule
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label fw-medium">
                                        Priority Level <span class="text-danger">*</span>
                                    </label>
                                    <div class="d-flex gap-2">
                                        <label class="priority-card flex-fill">
                                            <input type="radio" name="priority" value="low" 
                                                   {{ old('priority') == 'low' ? 'checked' : '' }}>
                                            <div class="card border-2 text-center h-100">
                                                <div class="card-body py-3">
                                                    <div class="fs-1 mb-2">🟢</div>
                                                    <div class="fw-semibold">Low</div>
                                                </div>
                                            </div>
                                        </label>
                                        <label class="priority-card flex-fill">
                                            <input type="radio" name="priority" value="medium" 
                                                   {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }}>
                                            <div class="card border-2 text-center h-100">
                                                <div class="card-body py-3">
                                                    <div class="fs-1 mb-2">🟡</div>
                                                    <div class="fw-semibold">Medium</div>
                                                </div>
                                            </div>
                                        </label>
                                        <label class="priority-card flex-fill">
                                            <input type="radio" name="priority" value="high" 
                                                   {{ old('priority') == 'high' ? 'checked' : '' }}>
                                            <div class="card border-2 text-center h-100">
                                                <div class="card-body py-3">
                                                    <div class="fs-1 mb-2">🔴</div>
                                                    <div class="fw-semibold">High</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label for="due_date" class="form-label fw-medium">Due Date</label>
                                    <input type="date" 
                                           class="form-control @error('due_date') is-invalid @enderror" 
                                           id="due_date" 
                                           name="due_date" 
                                           value="{{ old('due_date') }}"
                                           min="{{ date('Y-m-d') }}">
                                    <div class="form-text">
                                        <i class="fas fa-info-circle"></i> Optional: Set a deadline for this task
                                    </div>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 justify-content-center pt-3">
                                <a href="{{ url('/tasks') }}" class="btn btn-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-check me-2"></i>Create Task
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Character counter for title
        const titleInput = document.getElementById('title');
        const titleCounter = document.getElementById('titleCounter');
        
        titleInput.addEventListener('input', function() {
            titleCounter.textContent = this.value.length;
        });
        
        // Set initial counter value
        titleCounter.textContent = titleInput.value.length;
    </script>
</body>
</html>