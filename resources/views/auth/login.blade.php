<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ToDoList</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="min-vh-100 d-flex align-items-center justify-content-center p-4">
        <div class="card shadow-sm" style="max-width: 440px; width: 100%;">
            <div class="card-body p-4 p-md-5">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="text-primary mb-3">
                        <i class="fas fa-check-circle fa-3x"></i>
                    </div>
                    <h1 class="h3 fw-semibold mb-2">Welcome Back</h1>
                    <p class="text-muted small">Sign in to your account</p>
                </div>
                
                <!-- Alert (hidden by default) -->
                <div class="alert alert-danger d-none" role="alert" id="errorAlert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <span id="errorMessage"></span>
                </div>

                <!-- Login Form -->
                <form method="POST" action="/login">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               required autofocus placeholder="name@example.com">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-medium">Password</label>
                        <input type="password" class="form-control" id="password" 
                               name="password" required placeholder="Enter your password">
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2">
                            Sign In
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="position-relative my-4">
                    <hr class="text-muted">
                    <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 text-muted small">OR</span>
                </div>

                <!-- Sign Up Link -->
                <div class="text-center">
                    <p class="mb-3 text-muted">
                        Don't have an account? 
                        <a href="/register" class="text-decoration-none fw-medium">Sign Up</a>
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