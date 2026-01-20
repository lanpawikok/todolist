<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - ToDoList</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="min-vh-100 d-flex align-items-center justify-content-center p-4">
        <div class="card shadow-sm" style="max-width: 520px; width: 100%;">
            <div class="card-body p-4 p-md-5">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="text-primary mb-3">
                        <i class="fas fa-rocket fa-3x"></i>
                    </div>
                    <h1 class="h3 fw-semibold mb-2">Create Your Account</h1>
                    <p class="text-muted small">Start organizing your tasks today - it's free!</p>
                </div>
                
                <!-- Alert -->
                @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Please fix the following:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Register Form -->
                <form method="POST" action="/register">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-medium">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name') }}" required autofocus placeholder="Enter your full name">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email') }}" required placeholder="name@example.com">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-medium">Password</label>
                        <input type="password" class="form-control" id="password" 
                               name="password" required placeholder="Create a strong password">
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>Minimum 8 characters
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-medium">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" 
                               name="password_confirmation" required placeholder="Re-enter your password">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="position-relative my-4">
                    <hr class="text-muted">
                    <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 text-muted small">ALREADY A MEMBER?</span>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="mb-3 text-muted">
                        Have an account? 
                        <a href="/login" class="text-decoration-none fw-medium">Sign In</a>
                    </p>
                </div>

                <!-- Back to Home -->
                <div class="text-center">
                    <a href="/" class="text-muted text-decoration-none small">
                        <i class="fas fa-arrow-left me-2"></i>Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>