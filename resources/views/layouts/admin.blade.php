<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Minimal custom CSS hanya untuk sidebar fixed positioning */
        .sidebar-fixed {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            overflow-y: auto;
            transition: margin-left 0.3s;
        }
        
        .main-content-offset {
            margin-left: 260px;
            transition: margin-left 0.3s;
        }
        
        @media (max-width: 768px) {
            .sidebar-fixed {
                margin-left: -260px;
            }
            .sidebar-fixed.show {
                margin-left: 0;
            }
            .main-content-offset {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-light">
    <!-- Sidebar -->
    <div class="sidebar-fixed bg-primary text-white" id="sidebar" style="width: 260px;">
        <div class="p-4 text-center border-bottom border-white border-opacity-10">
            <h4 class="fw-bold mb-0"><i class="fas fa-crown"></i> Admin Panel</h4>
        </div>

        <div class="py-3">
            <div class="px-3 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm w-100 text-start mb-2 {{ request()->routeIs('admin.dashboard') ? '' : 'btn-outline-light' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </div>

            <div class="px-3 mb-1">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm w-100 text-start mb-2 {{ request()->routeIs('admin.users*') ? '' : 'btn-outline-light' }}">
                    <i class="fas fa-users me-2"></i>Users
                </a>
            </div>

            <div class="px-3 mb-1">
                <a href="{{ route('admin.tasks.index') }}" class="btn btn-light btn-sm w-100 text-start mb-2 {{ request()->routeIs('admin.tasks*') ? '' : 'btn-outline-light' }}">
                    <i class="fas fa-tasks me-2"></i>Tasks
                </a>
            </div>

            <hr class="border-white border-opacity-10 mx-3 my-3">

            <div class="px-3 mb-1">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-light btn-sm w-100 text-start mb-2">
                    <i class="fas fa-user-circle me-2"></i>Profile
                </a>
            </div>

            <div class="px-3">
                <form action="{{ route('logout') }}" method="POST" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100 text-start">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content-offset">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white shadow-sm sticky-top">
            <div class="container-fluid px-4">
                <button class="btn btn-link d-md-none text-dark" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0 fw-semibold">@yield('title', 'Dashboard')</h5>

                <div class="ms-auto">
                    <div class="dropdown">
                        <button class="btn btn-link text-dark text-decoration-none p-0" type="button" data-bs-toggle="dropdown">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-semibold" style="width: 40px; height: 40px;">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="text-start d-none d-md-block">
                                    <div class="fw-semibold small">{{ auth()->user()->name }}</div>
                                    <small class="text-muted" style="font-size: 0.75rem;">Administrator</small>
                                </div>
                                <i class="fas fa-chevron-down small"></i>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="mb-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="p-4">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (Optional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = event.target.closest('[onclick="toggleSidebar()"]');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !toggle) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>