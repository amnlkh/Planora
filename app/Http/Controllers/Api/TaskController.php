<?php

namespace App\Http\Controllers\Api;

use App\Contracts\TaskServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected TaskServiceInterface $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $tasks = $this->taskService->getAllTasks($request->only(['status', 'sort']));

        return response()->json([
            'status' => 'success',
            'data' => $tasks,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'deadline' => ['required', 'date'],
            'status' => ['nullable', 'in:pending,done'],
        ]);

        $task = $this->taskService->createTask($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Tugas berhasil ditambahkan',
            'data' => $task,
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'deadline' => ['required', 'date'],
            'status' => ['required', 'in:pending,done'],
        ]);

        $task = $this->taskService->updateTask($id, $validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Tugas berhasil diperbarui',
            'data' => $task,
        ]);
    }

    public function destroy(int $id)
    {
        $this->taskService->deleteTask($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Tugas berhasil dihapus',
        ]);
    }
}