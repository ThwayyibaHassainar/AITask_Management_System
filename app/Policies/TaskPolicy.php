<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;

class TaskPolicy
{
    public function view(User $user, Task $task)
    {
        return $user->isAdmin() || $task->assigned_to === $user->id;
    }
    /**
     * View list of tasks
     */
    public function viewAny(User $user): bool
    {
        return true; // allow authenticated users
    }

    /**
     * View single task
     */
    // public function view(User $user, Task $task): bool
    // {
    //     return $user->isAdmin() || $task->assigned_to === $user->id;
    // }

    /**
     * Create task
     */
    public function create(User $user): bool
    {
        return true; // allow logged in users
    }

    /**
     * Update task
     */
    public function update(User $user, Task $task): bool
    {
        return $user->isAdmin() || $task->assigned_to === $user->id;
    }

    /**
     * Delete task
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->isAdmin();
    }
}