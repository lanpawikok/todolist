<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Cek apakah user bisa update task ini
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * Cek apakah user bisa delete task ini
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }
}