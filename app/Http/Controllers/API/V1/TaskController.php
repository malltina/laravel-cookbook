<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::all();

        return $tasks;
    }

    public function store(Request $request)
    {

        $fields = $request->validate([
            'title'       => ['required', 'string'],
            'description' => ['sometimes', 'nullable', 'string'],
            'due_at'      => ['required', 'date'],
            'parent_id'   => ['sometimes', 'nullable', 'exists:tasks,id'],
        ]);
        $task   = Task::create([
            'title'       => $fields['title'],
            'description' => $fields['description'] ?? '',
            'due_at'      => $fields['due_at'],
            'parent_id'   => $fields['parent_id'] ?? null,
        ]);

        return $task;
    }

    public function show(Task $task)
    {
//        $task=Task::query()->without('children')->find($taskId);
        return $task;
    }

    public function update(Request $request, Task $task)
    {
//        $fields = $request->validate([
//            'title' => ['required','string'],
//            'description' => ['sometimes','nullable', 'string'],
//            'due_at'=>['required','date'],
//            'parent_id' =>['sometimes','nullable' ,'exists:tasks,id']
//        ]);
        $task->update([
            'title'        => $request->get('title'),
            'description'  => $request->get('description'),
            'due_at'       => $request->get('due_at'),
            'parent_id'    => $request->get('parent_id'),
            'is_completed' => $request->get('is_completed'),
        ]);

        return $task;
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return $task;
    }

    public function toggleCompleted(Task $task)
    {
        $task->update([
            'is_completed' => !$task->is_completed,
        ]);

        return $task;
    }

    public function filter(Request $request)
    {
        $request->validate([
            'name' => [
                Rule::in([
                    'todayTask',
                    'tomorrowTask',
                    'completed',
                    'uncompleted',
                    'nextWeekTasks',
                ]),
            ],
        ]);
        $method = $request->get('name');

        return $this->$method();
    }

    public function todayTask()
    {
        return Task::whereDate('due_at', Carbon::today())->get();
    }

    public function tomarrowTask()
    {
        return Task::whereDate('due_at', Carbon::tomorrow())->get();
    }

    public function completed()
    {
        return Task::with('children')
                   ->where('is_completed', true)
                   ->get();
    }

    public function uncompleted()
    {
        return Task::with('children')
                   ->where('is_completed', false)
                   ->get();
    }

    public function nextWeekTasks()
    {
        return Task::with('children')
                   ->whereBetween('due_at',
                       [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()->addDays(7)])
                   ->get();
    }
}
