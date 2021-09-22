<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $request->is_completed,
            'due_at' => $request->due_at,
            'task_id' => $request->task_id
        ]);
    }

    public function taskFilter(Request $request)
    {
        $due_at = $request->get('due_at');
        return Task::query()->where('due_at', $due_at)->get();
    }

    public function destroy(Task $task)
    {
        $task->delete();
    }
}
