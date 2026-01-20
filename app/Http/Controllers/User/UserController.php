<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $tasks = Task::with('creator')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('user.dashboard', compact('tasks'));
    }

    public function myTasks()
    {
        $tasks = Task::with('creator')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('user.tasks', compact('tasks'));
    }

    public function updateTaskStatus(Request $request, $id)
    {
        $task = Task::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        $task->update($validated);

        return redirect()->back()
            ->with('success', 'Task status updated successfully!');
    }
}
