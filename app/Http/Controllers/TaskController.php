<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Menampilkan daftar task dengan fitur search dan filter
    public function index(Request $request)
    {
        $query = Auth::user()->tasks();

        // Fitur Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Fitur Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Fitur Filter Priority
        if ($request->has('priority') && $request->priority !== '') {
            $query->where('priority', $request->priority);
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // ✅ ADDED: Stats untuk dashboard
        $stats = [
            'total' => Auth::user()->tasks()->count(),
            'pending' => Auth::user()->tasks()->where('status', 'pending')->count(),
            'in_progress' => Auth::user()->tasks()->where('status', 'in_progress')->count(),
            'completed' => Auth::user()->tasks()->where('status', 'completed')->count(),
        ];
        
        return view('tasks.index', compact('tasks', 'stats'));
    }

    // Menampilkan form create task
    public function create()
    {
        return view('tasks.create');
    }

    // Menyimpan task baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'nullable|in:pending,in_progress,completed'
        ]);

        $data = $request->all();
        
        // Set default status jika tidak ada
        if (!isset($data['status'])) {
            $data['status'] = 'pending';
        }

        Auth::user()->tasks()->create($data);

        return redirect()->route('tasks.index')->with('success', 'Task berhasil ditambahkan!');
    }

    // Menampilkan form edit task
    public function edit(Task $task)
    {
        // Cek authorization
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('tasks.edit', compact('task'));
    }

    // Update task yang sudah ada
    public function update(Request $request, Task $task)
    {
        // Cek authorization
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'nullable|in:pending,in_progress,completed'
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task berhasil diupdate!');
    }

    // Hapus task (Soft Delete)
    public function destroy(Task $task)
    {
        // Cek authorization
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $task->delete(); // Soft delete

        return redirect()->route('tasks.index')->with('success', 'Task berhasil dihapus!');
    }

    // Toggle status complete/incomplete
    public function toggleComplete(Task $task)
    {
        // Cek authorization
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Toggle status antara completed dan pending
        if ($task->status === 'completed') {
            $task->update(['status' => 'pending']);
        } else {
            $task->update(['status' => 'completed']);
        }

        return redirect()->back()->with('success', 'Status task berhasil diupdate!');
    }

    // ===== RECYCLE BIN METHODS =====
    
    // Menampilkan task yang sudah dihapus (Recycle Bin)
    public function trash()
    {
        // ✅ FIXED: Query langsung dari Model Task, bukan dari relasi
        $tasks = Task::onlyTrashed()
            ->where('user_id', Auth::id())
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);
        
        return view('tasks.trash', compact('tasks'));
    }

    // Restore task dari recycle bin
    public function restore($id)
    {
        // ✅ FIXED: Query langsung dari Model Task
        $task = Task::onlyTrashed()
            ->where('user_id', Auth::id())
            ->findOrFail($id);
            
        $task->restore();
        
        return redirect()->route('tasks.trash')->with('success', 'Task berhasil dipulihkan!');
    }

    // Hapus task secara permanen
    public function forceDelete($id)
    {
        // ✅ FIXED: Query langsung dari Model Task
        $task = Task::onlyTrashed()
            ->where('user_id', Auth::id())
            ->findOrFail($id);
            
        $task->forceDelete();
        
        return redirect()->route('tasks.trash')->with('success', 'Task berhasil dihapus permanen!');
    }
}