<?php

use App\Http\Controllers\API\v1\TaskController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1','as'=>'tasks.'], function () {
    Route::get('tasks', [TaskController::class, 'index'])->name('index');
    Route::post('tasks', [TaskController::class, 'store'])->name('store');
    Route::get('tasks/filter', [TaskController::class, 'filter']);
    Route::get('tasks/{task}', [TaskController::class, 'show']);
    Route::put('tasks/{task}', [TaskController::class, 'update']);
    Route::delete('tasks/{taskId}', [TaskController::class, 'destroy']);
    Route::patch('tasks/{taskId}/toggle', [TaskController::class, 'toggle']);
});
