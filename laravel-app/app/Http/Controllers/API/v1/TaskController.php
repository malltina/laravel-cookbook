<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        $task = Task::create([
            'title' => $request->get('title'),
            'scheduled_for' => $request->get('scheduled_for'),
            'parent_id' => $request->get('parent_id'),
        ]);

        return $task;
    }

    public function show(int $task_id)
    {
        $task = Task::findOrFail($task_id, ['title', 'completed', 'scheduled_for', 'parent_id']);
        return $task;
    }

    public function update(Request $request, int $task_id)
    {
        $task = Task::findOrFail($task_id)->update([
            'title' => $request->get('title'),
            'scheduled_for' => $request->get('scheduled_for'),
            'parent_id' => $request->get('parent_id'),
            'completed' => $request->get('completed')
        ]);
        return $task;
    }

    public function destroy(int $task_id)
    {
        $task = Task::findOrFail($task_id)->delete();
        return $task;
    }

    public function makeCompleted(int $task_id)
    {
        $task = Task::findOrFail($task_id)->update([
            'completed' => 1,
        ]);
        return $task;
    }

    public function makeUnCompleted(int $task_id)
    {
        $task = Task::findOrFail($task_id)->update([
            'completed' => 0,
        ]);
        return $task;
    }
}
