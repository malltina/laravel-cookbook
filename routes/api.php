<?php


use App\Http\Controllers\API\v1\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1','as'=>'tasks.'], function () {

    Route::post('tasks', [TaskController::class, 'store']);
    Route::get('tasks/schedule', [TaskController::class, 'schedule']);
    Route::get('tasks', [TaskController::class, 'index']);
    Route::put('tasks/{task}', [TaskController::class, 'update']);
    Route::delete('tasks/{taskId}', [TaskController::class, 'destroy']);

});
