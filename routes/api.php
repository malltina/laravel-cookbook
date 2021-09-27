<?php

use App\Http\Controllers\API\V1\TaskController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' =>'v1'],function(){
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);
    Route::get('/tasks/{task}', [TaskController::class, 'show']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
    Route::get('task/filter', [TaskController::class, 'filter']);
    Route::patch('/tasks/{task}/toggle-completed', [TaskController::class, 'toggleCompleted']);
});
