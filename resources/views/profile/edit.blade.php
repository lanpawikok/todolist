<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - ToDoList</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold text-primary mb-0">
                <i class="fas fa-user-circle"></i> Edit Profile
            </span>
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
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
            <h1 class="h3 fw-bold text-primary mb-0">
                <i class="fas fa-user-edit"></i> Edit Profile
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

        <!-- Avatar Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center p-4">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold mx-auto mb-3" style="width: 150px; height: 150px; font-size: 3rem; overflow: hidden;">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
                <h4 class="mb-1">{{ Auth::user()->name }}</h4>
                <p class="text-muted mb-3">{{ Auth::user()->email }}</p>
                @if(Auth::user()->avatar)
                    <form action="{{ route('profile.avatar.delete') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete avatar?')">
                            <i class="fas fa-trash-alt"></i> Delete Photo
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- Profile Information -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4 pb-3 border-bottom border-primary">
                            <i class="fas fa-user me-2"></i>Profile Information
                        </h5>
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-image me-2"></i>Profile Picture
                                </label>
                                <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*" onchange="previewImage(this)">
                                <small class="form-text text-muted">Max 2MB (JPEG, PNG, GIF)</small>
                                @error('avatar')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <div id="imagePreview" class="mt-3"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-user me-2"></i>Name
                                </label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4 pb-3 border-bottom border-primary">
                            <i class="fas fa-key me-2"></i>Change Password
                        </h5>
                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-lock me-2"></i>Current Password
                                </label>
                                <input type="password" name="current_password" class="form-control" required>
                                @error('current_password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-lock me-2"></i>New Password
                                </label>
                                <input type="password" name="password" class="form-control" required>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-lock me-2"></i>Confirm New Password
                                </label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key me-2"></i>Update Password
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
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div class="text-center">
                            <img src="${e.target.result}" class="img-fluid rounded shadow-sm" style="max-width: 200px; max-height: 200px;">
                            <div class="mt-2">
                                <small class="text-success"><i class="fas fa-check-circle me-1"></i>Image ready to upload</small>
                            </div>
                        </div>
                    `;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>