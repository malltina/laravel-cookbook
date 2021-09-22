<?php

use App\Http\Controllers\API\v1\TaskController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::get('tasks', [TaskController::class, 'index']);
    Route::post('tasks', [TaskController::class, 'store']);
    Route::get('tasks/filter', [TaskController::class, 'filter']);
    Route::get('tasks/{taskId}', [TaskController::class, 'show']);
    Route::put('tasks/{taskId}', [TaskController::class, 'update']);
    Route::delete('tasks/{taskId}', [TaskController::class, 'destroy']);
    Route::patch('tasks/{taskId}/toggle', [TaskController::class, 'toggle']);
    Route::patch('tasks/{taskId}/completed', [TaskController::class, 'makeCompleted']);
    Route::patch('tasks/{taskId}/uncompleted', [TaskController::class, 'makeUnCompleted']);
});
