<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TaskStoreRequest;
use function array_merge;
use App\Http\Requests\TaskUpdateRequest;

class TaskController extends Controller
{

//    protected $rules = [
//        'name'        => 'required|max:60',
//        'description' => 'max:155',
//        'completed'   => 'numeric',
//    ];
    public function index(Request $request)
    {
        return Task::filter($request->all())->get();
    }

    public function store(TaskStoreRequest $request)
    {
//        $this->validate($request, $this->rules);
//        $user            = Auth::user();
//        $task            = $request->all();
//        $task['user_id'] = $user->id;
        $attributes = array_merge($request->validated(), ['user_id' => Auth::id()]);
        Task::create($attributes);
        //        return
    }

    public function update(Task $task, TaskUpdateRequest $request)
    {
//        $this->validate($request, $this->rules);
//        $task->name        = $request->input('name');
//        $task->description = $request->input('description');
//        $task->completed   = $request->input('completed');
//        $task->save();
        $task->update($request->validated());
        //        return
    }

    public function destroy(Task $task)
    {
        $task->delete();
//        return
    }

//    public function completed()
//    {
//        $tasks = Task::with('users')
//                     ->where('completed', true)
//                     ->get();
//
//        return $tasks;
//    }
//
//    public function uncompleted()
//    {
//        $tasks = Task::with('users')
//                     ->where('completed', false)
//                     ->get();
//
//        return $tasks;
//    }

//    protected function schedule(Schedule $schedule)
//    {
//        $schedule->call(function () {
//            DB::table('tasks')->where('completed', false)->delete();
//        })->daily();
//    }

}
