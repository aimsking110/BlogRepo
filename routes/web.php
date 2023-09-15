<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/auth/register',[AuthController::class,'register']);

Route::post('/auth/login',[AuthController::class,'login']);

Route::get('/updatePost', [PostController::class,'edit']);
Route::get('/userPost', [PostController::class,'index']);

Route::post('/comments', [CommentController::class,'store']);Route::get('/show', [CommentController::class,'show']);