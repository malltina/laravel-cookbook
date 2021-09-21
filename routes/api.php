<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\PostController;

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
Route::group(['prefix' =>'v1'],function(){
    Route::post('posts', [PostController::class,'store']);
    Route::get('posts', [PostController::class, 'index']);
    Route::put('posts/{postId}', [PostController::class, 'update']);
    Route::get('posts/{postId}', [PostController::class, 'show']);
    Route::delete('posts/{postId}',[PostController::class,'destroy']);
});

/*
 * get -> all posts -> posts
 * get -> show post -> posts/{post}
 * post -> create post -> posts
 * put -> update post -> posts/{post}
 * delete -> delete post -> posts/{post}
 */
