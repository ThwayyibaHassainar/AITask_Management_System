<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class TaskController extends Controller
{
    private TaskService $service;

    public function __construct(TaskService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    // public function index()
    // {
    //     $tasks = $this->service->getAll();
    //     $stats = $this->service->getStats();

    //     return view('tasks.index', compact('tasks','stats'));
    // }
    public function index(Request $request)
    {
        $tasks = $this->service->getAll($request->all());
        $stats = $this->service->getStats();

        return view('tasks.index', compact('tasks','stats'));
    }

    public function create()
    {
        $users = $this->service->getAssignableUsers();
        return view('tasks.create', compact('users'));
    }

    public function store(StoreTaskRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success','Task created successfully');
    }

    public function show(int $id)
    {
        $task = $this->service->find($id);

        $this->authorize('view', $task); // ✅ POLICY

        return view('tasks.show', compact('task'));
    }

    public function edit(int $id)
    {
        $task = $this->service->find($id);

        $this->authorize('update', $task); // ✅ POLICY

        $users = $this->service->getAssignableUsers();

        return view('tasks.create', compact('task','users'));
    }

    public function update(UpdateTaskRequest $request, int $id)
    {
        $task = $this->service->find($id);

        $this->authorize('update', $task);

        $this->service->update($id,$request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success','Task updated');
    }

    public function destroy(int $id)
    {
        $task = $this->service->find($id);

        $this->authorize('delete', $task);

        $this->service->delete($id);

        return redirect()->route('tasks.index');
    }

    public function updateStatus(int $id, string $status)
    {
        $task = $this->service->find($id);

        $this->authorize('update', $task);

        $this->service->updateStatus($id, $status);

        return back();
    }

    public function usersList()
    {
        $users = User::latest()->paginate(10);

        return view('admin.index', compact('users'));
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|in:user,admin'
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return back()->with('success', 'Role updated successfully');
    }
}