@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">My Tasks</h1>
        <p class="text-gray-600">Tasks assigned to you</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tasks Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-gray-500 text-sm">Total Tasks</div>
            <div class="text-2xl font-bold">{{ $tasks->total() }}</div>
        </div>
        <div class="bg-yellow-50 rounded-lg shadow p-6">
            <div class="text-yellow-700 text-sm">Pending</div>
            <div class="text-2xl font-bold text-yellow-700">{{ $tasks->where('status', 'pending')->count() }}</div>
        </div>
        <div class="bg-blue-50 rounded-lg shadow p-6">
            <div class="text-blue-700 text-sm">In Progress</div>
            <div class="text-2xl font-bold text-blue-700">{{ $tasks->where('status', 'in_progress')->count() }}</div>
        </div>
        <div class="bg-green-50 rounded-lg shadow p-6">
            <div class="text-green-700 text-sm">Completed</div>
            <div class="text-2xl font-bold text-green-700">{{ $tasks->where('status', 'completed')->count() }}</div>
        </div>
    </div>

    <!-- Tasks List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created By</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tasks as $task)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500">{{ Str::limit($task->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->priority_color }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $task->due_date ? $task->due_date->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->status_color }}">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $task->creator->name ?? 'Admin' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <form action="{{ route('user.tasks.update-status', $task->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="text-sm border-gray-300 rounded">
                                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No tasks assigned to you yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($tasks->hasPages())
        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    @endif
</div>
@endsection