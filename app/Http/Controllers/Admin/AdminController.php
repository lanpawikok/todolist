<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalTasks = Task::count();
        $completedTasks = Task::where('is_completed', true)->count();
        $pendingTasks = Task::where('is_completed', false)->count();
        
        $recentUsers = User::latest()->take(5)->get();
        $recentTasks = Task::with('user')->latest()->take(10)->get();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'recentUsers',
            'recentTasks'
        ));
    }

    // ===== USER MANAGEMENT =====
    public function users(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('is_admin', $request->role === 'admin' ? true : false);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'is_admin' => 'required|boolean'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function showUser($id)
    {
        $user = User::with('tasks')->findOrFail($id);
        $tasks = $user->tasks;

        $taskStats = [
            'total' => $tasks->count(),
            'completed' => $tasks->where('is_completed', true)->count(),
            'pending' => $tasks->where('is_completed', false)->count(),
        ];

        return view('admin.users.show', compact('user', 'tasks', 'taskStats'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'is_admin' => 'required|boolean'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->is_admin
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $user->tasks()->delete();
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    // ===== TASK MANAGEMENT =====
    public function tasks(Request $request)
    {
        $query = Task::with('user');

        if ($request->has('search') && $request->search != '') {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status === 'completed') {
                $query->where('is_completed', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_completed', false);
            }
        }

        if ($request->has('priority') && $request->priority != '') {
            $query->where('priority', $request->priority);
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.tasks.index', compact('tasks'));
    }

    public function createTask()
    {
        $users = User::orderBy('name')->get();
        return view('admin.tasks.create', compact('users'));
    }

    public function storeTask(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high'
        ]);

        Task::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
        ]);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task berhasil ditambahkan!');
    }

    public function showTask($id)
    {
        $task = Task::with('user')->findOrFail($id);
        $users = User::all();
        
        return view('admin.tasks.show', compact('task', 'users'));
    }

    public function editTask($id)
    {
        $task = Task::findOrFail($id);
        $users = User::orderBy('name')->get();
        return view('admin.tasks.edit', compact('task', 'users'));
    }

    public function updateTask(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high'
        ]);

        $task->update($request->all());

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task berhasil diupdate!');
    }

    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task berhasil dihapus!');
    }

    public function toggleTaskComplete($id)
    {
        $task = Task::findOrFail($id);
        $task->update(['is_completed' => !$task->is_completed]);

        return redirect()->back()
            ->with('success', 'Status task berhasil diupdate!');
    }

    // ===== STATS =====
    public function stats()
    {
        $tasksPerUser = User::withCount('tasks')->get();
        return view('admin.dashboard.stats', compact('tasksPerUser'));
    }
}
