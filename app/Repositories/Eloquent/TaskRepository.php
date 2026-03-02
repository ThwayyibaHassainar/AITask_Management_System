<?php

// app/Repositories/Eloquent/TaskRepository.php
namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{

    public function all(array $filters = [])
    {
        return Task::query()->with('user')->filter($filters)->paginate(10);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    
    // public function getAllTask(array $filters = [])
    // {
    //     return Task::with('user')->paginate(10);
    // }

    public function find(int $id): Task
    {
        return Task::with('user')->findOrFail($id);
    }

    public function update(int $id, array $data): Task
    {
        $task = Task::findOrFail($id);
        $task->update($data);
        return $task;
    }

    public function delete(int $id): bool
    {
        return Task::destroy($id);
    }

    public function query()
    {
        return Task::query();
    }

    public function filter(array $filters)
    {
        $query = Task::query()->with('user');

        // If not admin → only own tasks
        if (!auth()->user()->isAdmin()) {
            $query->where('assigned_to', auth()->id());
        }

        // Search by title
        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by priority
        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        return $query->latest()->paginate(10)->withQueryString();
    }
}

?>