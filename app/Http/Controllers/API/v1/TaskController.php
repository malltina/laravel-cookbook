<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    protected $rules = [
        'name' => 'required|max:60',
        'description' => 'max:155',
        'completed' => 'numeric',

    ];


    public function index(Request $request)
    {
        return Task::filter($request->all())->get();


    }


    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $user = Auth::user();
        $task = $request->all();
        $task['user_id'] = $user->id;
        Task::create($task);

    }


    public function update(Task $task, Request $request, $id)
    {
        $this->validate($request, $this->rules);

        $task = Task::findOrFail($id);
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->completed = $request->input('completed');
        $task->save();


    }


    public function destroy($id)
    {
        Task::findOrFail($id)->delete();


    }

    public function completed()
    {
        $tasks = Task::with('users')
            ->where('completed', true)
            ->get();

        return $tasks;
    }

    public function uncompleted()
    {
        $tasks = Task::with('users')
            ->where('completed', false)
            ->get();

        return $tasks;
    }

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            DB::table('tasks')->where('completed', false)->delete();
        })->daily();
    }

}
