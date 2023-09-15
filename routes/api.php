<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function()
{
    Route::get('/userPost', [PostController::class,'index']);
    Route::post('/addpost', [PostController::class,'store']);
    //Route::get('/posts/edit', [PostController::class, 'edit']);
    Route::get('/posts', [PostController::class,'show']);
    Route::post('/comments', [CommentController::class,'store']);
    Route::get('/show', [CommentController::class,'show']);

    Route::put('posts/{id}', [PostController::class,'update']);


} );

Route::post('/auth/register',[AuthController::class,'register']);
Route::post('/auth/login',[AuthController::class,'login']);

//Route::post('/comments', 'CommentController@store'); // Create a comment
//  Route::get('/comments/{comment}', 'CommentController@show'); // Retrieve a comment
Route::put('/comments/{comment}', 'CommentController@update'); // Update a comment
Route::delete('/comments/{comment}', 'CommentController@destroy'); // Delete a comment


//Route::middleware('auth:api')->get('posts/{id}/edit', 'PostController@edit');
