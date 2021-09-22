<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
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
        $task = Task::create([
            'title' => $request->get('title'),
            'scheduled_for' => $request->get('scheduled_for'),
            'parent_id' => $request->get('parent_id'),
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

    public function filter(Request $request)
    {
        $scheduled_for = $request->get('scheduled_for');
        if ($scheduled_for == 'this_week') {
            $task = Task::with('children')->whereBetween('scheduled_for', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        } elseif ($scheduled_for == 'next_week') {
            $task = Task::with('children')->whereBetween('scheduled_for', [Carbon::now()->endOfWeek(), Carbon::now()->endOfWeek()->addDays(7)])->get();
        } else {
            $task = Task::with('children')->whereDate('scheduled_for', Carbon::$scheduled_for())->get();
        }
        return $task;
    }
}
