<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: #f5f6fa;
            min-height: 100vh;
        }
        
        /* Sidebar (sama seperti dashboard) */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 0;
            z-index: 1000;
            box-shadow: 5px 0 30px rgba(0,0,0,0.1);
        }
        
        .sidebar-brand {
            padding: 0 30px;
            margin-bottom: 40px;
        }
        
        .sidebar-brand h3 {
            color: white;
            font-weight: 700;
            font-size: 24px;
        }
        
        .sidebar-brand .badge {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 15px 30px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            gap: 15px;
        }
        
        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background: rgba(255,255,255,0.2);
            color: white;
            border-left: 4px solid white;
        }
        
        .sidebar-menu li a i {
            font-size: 20px;
            width: 25px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 30px;
        }
        
        .top-bar {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }
        
        .btn-add {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .content-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .table-custom {
            width: 100%;
        }
        
        .table-custom thead {
            background: #f8f9fa;
        }
        
        .table-custom th {
            padding: 15px;
            font-weight: 600;
            color: #666;
            border: none;
        }
        
        .table-custom td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .badge-role {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-staff {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }
        
        .badge-user {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
        }
        
        .alert-success-custom {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h3><i class="fas fa-crown"></i> ToDoList</h3>
            <span class="badge">ADMIN PANEL</span>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users') }}" class="active">
                    <i class="fas fa-users"></i>
                    <span>Manage Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tasks') }}">
                    <i class="fas fa-tasks"></i>
                    <span>Manage Tasks</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/tasks') }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>My Personal Tasks</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <h1 class="page-title">
                <i class="fas fa-users me-2"></i>Manage Users
            </h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-add">
                <i class="fas fa-user-plus me-2"></i>Add New User
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success-custom alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Users Table -->
        <div class="content-card">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tasks</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <strong>{{ $user->name }}</strong>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge-role badge-{{ $user->role }}">
                                    <i class="fas fa-{{ $user->role === 'staff' ? 'user-tie' : 'user' }} me-1"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span style="background: #e3f2fd; color: #1976d2; padding: 5px 15px; border-radius: 10px; font-weight: 600;">
                                    {{ $user->tasks->count() }} Tasks
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <form action="{{ route('admin.users.delete', $user) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="fas fa-trash-alt me-1"></i>Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 50px;">
                                <i class="fas fa-users" style="font-size: 64px; color: #ddd;"></i>
                                <p style="margin-top: 20px; color: #999;">No users found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>