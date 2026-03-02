<?php

namespace App\Services;

use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\User;

// class TaskService
// {
//     public function __construct(
//         protected TaskRepositoryInterface $repo,
//         protected AIService $aiService
//     ) {}

//     public function store(array $data)
//     {
//         return DB::transaction(function () use ($data) {

//             $task = $this->repo->create($data);

//             $aiData = $this->aiService->generateSummary($task);

//             return $this->repo->update($task->id, $aiData);
//         });
//     }
// }

class TaskService
{
    private TaskRepositoryInterface $repo;
    private AIService $aiService;

    public function __construct(
        TaskRepositoryInterface $repo,
        AIService $aiService
    ) {
        $this->repo = $repo;
        $this->aiService = $aiService;
    }

    /**
     * Get paginated tasks with filters
     */
    public function getAll(array $filters = [])
    {
        $query = $this->repo->query();

        if (!auth()->user()->isAdmin()) {
            $query->where('assigned_to', auth()->id());
        }

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%'.$filters['search'].'%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        return $query->latest()->paginate(10)->withQueryString();
    }

    /**
     * Find single task
     */
    public function find(int $id)
    {
        return $this->repo->find($id);
    }

    /**
     * Store task with AI generation
     */
    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            // Business rule: default status
            $data['status'] = $data['status'] ?? 'pending';

            // Create task
            $task = $this->repo->create($data);

            try {
                // AI processing
                $aiData = $this->aiService->generateSummary($task);

                $task = $this->repo->update($task->id, $aiData);

            } catch (Exception $e) {

                Log::error('AI generation failed: ' . $e->getMessage());

                // Fallback AI values
                $fallback = [
                    'ai_summary' => 'AI summary unavailable.',
                    'ai_priority' => $task->priority
                ];

                $task = $this->repo->update($task->id, $fallback);
            }

            return $task;
        });
    }

    /**
     * Update task
     */
    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $task = $this->repo->update($id, $data);

            // Optional: re-trigger AI if description changed
            if (isset($data['description'])) {

                try {
                    $aiData = $this->aiService->generateSummary($task);
                    $task = $this->repo->update($id, $aiData);

                } catch (Exception $e) {
                    Log::warning('AI regeneration failed on update.');
                }
            }

            return $task;
        });
    }

    /**
     * Delete task
     */
    public function delete(int $id)
    {
        return $this->repo->delete($id);
    }

    /**
     * Update only status
     */
    public function updateStatus(int $id, string $status)
    {
        return $this->repo->update($id, [
            'status' => $status
        ]);
    }

    /**
     * Get AI summary via API endpoint
     */
    public function getAISummary(int $id): array
    {
        $task = $this->repo->find($id);

        return [
            'ai_summary' => $task->ai_summary,
            'ai_priority' => $task->ai_priority
        ];
    }

    /**
     * Dashboard statistics
     */
    // public function getStats(): array
    // {
    //     $tasks = $this->getAll([]);

    //     return [
    //         'total' => $tasks->total(),
    //         'completed' => $tasks->where('status', 'completed')->count(),
    //         'pending' => $tasks->where('status', 'pending')->count(),
    //         'high' => $tasks->where('priority', 'high')->count(),
    //     ];
    // }

    public function getStats(): array
    {
        $user = Auth::user();

        $filters = [];

        if (!$user->isAdmin()) {
            $filters['assigned_to'] = $user->id;
        }

        $allTasks = $this->repo->all($filters)->getCollection();

        return [
            'total' => $allTasks->count(),
            'completed' => $allTasks->where('status','completed')->count(),
            'pending' => $allTasks->where('status','pending')->count(),
            'high' => $allTasks->where('priority','high')->count(),
        ];
    }

    /**
     * Users assignable to tasks
     */
    public function getAssignableUsers()
    {
        return User::where('role','user')->get();
    }
}