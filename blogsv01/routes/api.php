<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogsController;
use App\Http\Middleware\CheckAuthToken;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::get('/posts', [BlogsController::class, 'index']);
Route::get('/posts/{id}', [BlogsController::class, 'show']);
Route::get('/users/{id}/posts', [BlogsController::class, 'userPosts']);

Route::middleware([CheckAuthToken::class])->group(function () {
    Route::middleware('auth:sanctum')->post('/posts', [BlogsController::class, 'store']);
    Route::middleware('auth:sanctum')->put('/posts/{id}', [BlogsController::class, 'update']);
    Route::middleware('auth:sanctum')->delete('/posts/{id}', [BlogsController::class, 'destroy']);
});