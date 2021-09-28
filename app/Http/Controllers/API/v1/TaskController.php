<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Post;
use App\Models\Task;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{


    public function index(Request $request)
    {
        return Task::filter($request->all())->get();


    }


    public function store(StoreTaskRequest $request)
    {
        $attribute = array_merge($request->validated(), ['user_id' => Auth::id()]);
        Task::create($attribute);
        //return

    }


    public function update(Task $task, UpdateTaskRequest $request)
    {
        $task->update($request->validated());
        //return


    }


    public function destroy(Task $task)
    {
        $task->delete();
        //returrn


    }


    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            DB::table('tasks')->where('completed', false)->delete();
        })->daily();
    }

}
