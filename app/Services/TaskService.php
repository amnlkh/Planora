<?php

namespace App\Services;

use App\Contracts\TaskServiceInterface;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskService implements TaskServiceInterface
{
    public function getAllTasks(array $filters = [])
    {
        $query = Auth::user()->tasks();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['sort'])) {
            if ($filters['sort'] === 'deadline_asc') {
                $query->orderBy('deadline', 'asc');
            }

            if ($filters['sort'] === 'deadline_desc') {
                $query->orderBy('deadline', 'desc');
            }
        }

        return $query->get();
    }

    public function createTask(array $data)
    {
        return Auth::user()->tasks()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'deadline' => $data['deadline'],
            'status' => $data['status'] ?? Task::STATUS_PENDING,
        ]);
    }

    public function updateTask(int $id, array $data)
    {
        $task = Auth::user()->tasks()->findOrFail($id);

        $task->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'deadline' => $data['deadline'],
            'status' => $data['status'],
        ]);

        return $task;
    }

    public function deleteTask(int $id): bool
    {
        $task = Auth::user()->tasks()->findOrFail($id);

        return $task->delete();
    }
}