<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 600;
            color: #0d6efd;
        }
        
        .hero-section {
            padding: 80px 0;
            background-color: white;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 1rem;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            color: #6c757d;
            margin-bottom: 2rem;
        }
        
        .btn-hero {
            padding: 12px 30px;
            font-size: 1rem;
            border-radius: 5px;
            margin: 0 5px;
        }
        
        .stats-section {
            padding: 60px 0;
            background-color: #f8f9fa;
        }
        
        .stat-box {
            text-align: center;
            padding: 20px;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #0d6efd;
        }
        
        .stat-label {
            font-size: 1rem;
            color: #6c757d;
        }
        
        .feature-section {
            padding: 60px 0;
            background-color: white;
        }
        
        .feature-card {
            padding: 30px;
            text-align: center;
            height: 100%;
        }
        
        .feature-icon {
            font-size: 3rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }
        
        .feature-card h4 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        
        .feature-card p {
            color: #6c757d;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-check-circle"></i> ToDoList
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/tasks">
                            <i class="fas fa-tasks"></i> My Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="/register">
                            Sign Up
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <h1 class="hero-title">Organize Your Tasks Simply</h1>
                    <p class="hero-subtitle">A simple and effective to-do list app to help you stay productive</p>
                    <div>
                        <a href="/register" class="btn btn-primary btn-hero">
                            <i class="fas fa-rocket"></i> Mulai dengan gratis
                        </a>
                        <a href="/login" class="btn btn-outline-primary btn-hero">
                            <i class="fas fa-sign-in-alt"></i> Sign In  
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-box">
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">Happy Users</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-box">
                        <div class="stat-number">2M+</div>
                        <div class="stat-label">Tasks Completed</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-box">
                        <div class="stat-number">4.9/5</div>
                        <div class="stat-label">User Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="feature-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Secure & Private</h4>
                        <p>Your data is encrypted and protected with enterprise-grade security</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h4>Smart Search</h4>
                        <p>Find any task instantly with powerful search and filters</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-flag"></i>
                        </div>
                        <h4>Priority Management</h4>
                        <p>Set priorities and deadlines to stay on top of everything</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>