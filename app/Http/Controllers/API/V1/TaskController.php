<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('children')->get();
        return $tasks;
    }

    public function store(Request $request)
    {

        $fields = $request->validate([
            'title' => ['required','string'],
            'description' => ['nullable', 'string'],
            'due_at'=>['required','date'],
            'parent_id' =>['nullable' ,'exists:tasks,id']
        ]);

        $task = Task::create([
            'title' => $fields['title'],
            'description' => $fields['description'],
            'due_at' => $fields['due_at'],
            'parent_id' => $fields['parent_id']
        ]);
        return $task;
    }

    public function show(Task $task)
    {
        $task->load('children');

        return $task;
    }

    public function update(Request $request, Task $task)
    {
        $task->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'due_at' => $request->get('due_at'),
            'parent_id' => $request->get('parent_id'),
            'is_completed' => $request->get('is_completed'),
        ]);

        return $task;
    }

    public function destroy(Task $task)
    {
        $task->delete();
    }

    public function toggleCompleted(Task $task)
    {
        $task->update([
            'is_completed' => !$task->is_completed
        ]);
    }
}
