<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    protected const MAP = [
        'this_week' => 'weekTask',
        'next_week' => 'nextWeekTask',
        'today'     => 'todayTask',
        'tomorrow'  => 'tomarrowTask',
        'completed'  => 'completed',
        'uncompleted'  => 'uncompleted',
    ];

    public function index()
    {
        $tasks = Task::with('children')->get();
//        foreach ($tasks as $task){
//            $task['subtask'] = $tasks->filter(function ($currentTask) use($task){
//                return $currentTask->parent_id === $task->id;
//            });
//        }
        return $tasks;
    }

    public function store(Request $request)
    {
        $task = Task::create([
            'title'         => $request->get('title'),
            'scheduled_for' => $request->get('scheduled_for'),
            'parent_id'     => $request->get('parent_id'),
        ]);

        return $task;
    }

    public function show(int $task_id)
    {
        $task = Task::with('children')->where('id', $task_id)->get();

        return $task;
    }

    public function update(Request $request, int $task_id)
    {
        $task = Task::findOrFail($task_id);
        $task->update([
            'title'         => $request->get('title'),
            'scheduled_for' => $request->get('scheduled_for'),
            'parent_id'     => $request->get('parent_id'),
            'completed'     => $request->get('completed'),
        ]);

        return $task;
    }

    public function destroy(int $task_id)
    {
        $task = Task::findOrFail($task_id);
        $task->delete();

        return $task;
    }

    public function toggle(int $task_id)
    {
        $task = Task::findOrFail($task_id);
        $task->update([
            'completed' => !$task->completed,
        ]);

        return $task;
    }

    public function makeCompleted(int $task_id)
    {
        $task = Task::findOrFail($task_id);
        $task->update([
            'completed' => 1,
        ]);

        return $task;
    }

    public function makeUnCompleted(int $task_id)
    {
        $task = Task::findOrFail($task_id);
        $task->update([
            'completed' => 0,
        ]);

        return $task;
    }

    public function filter(Request $request)
    {
        $scheduled_for = $request->get('scheduled_for');
        $method_name   = self::MAP[$scheduled_for];// value

        return $this->$method_name();
    }

    public function weekTask()
    {
        $tasks = Task::with('children')
                     ->whereBetween('scheduled_for',
                         [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                     ->get();

        return $tasks;
    }

    public function todayTask()
    {
        $tasks = Task::with('children')
                     ->whereDate('scheduled_for', Carbon::today())
                     ->get();

        return $tasks;
    }

    public function nextWeekTask()
    {
        $tasks = Task::with('children')
                     ->whereBetween('scheduled_for',
                         [
                             Carbon::now()->endOfWeek(), Carbon::now()->endOfWeek()->addDays(7),
                         ])
                     ->get();

        return $tasks;
    }

    public function tomarrowTask()
    {
        $tasks = Task::with('children')
                     ->whereDate('scheduled_for', Carbon::tomorrow())
                     ->get();

        return $tasks;
    }

    public function completed()
    {
        $tasks = Task::with('children')
                     ->where('completed', true)
                     ->get();

        return $tasks;
    }

    public function uncompleted()
    {
        $tasks = Task::with('children')
                     ->where('completed', false)
                     ->get();

        return $tasks;
    }
}
