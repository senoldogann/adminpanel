<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Panel API Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::post('/auth/login', [\SenolDogan\AdminPanel\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/auth/register', [\SenolDogan\AdminPanel\Http\Controllers\Api\AuthController::class, 'register']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [\SenolDogan\AdminPanel\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/user/profile', [\SenolDogan\AdminPanel\Http\Controllers\Api\AuthController::class, 'profile']);
});

// Post Routes
Route::get('/posts', [\SenolDogan\AdminPanel\Http\Controllers\Api\PostController::class, 'index']);
Route::get('/posts/{slug}', [\SenolDogan\AdminPanel\Http\Controllers\Api\PostController::class, 'show']);
Route::get('/categories', [\SenolDogan\AdminPanel\Http\Controllers\Api\PostController::class, 'categories']);
Route::get('/tags', [\SenolDogan\AdminPanel\Http\Controllers\Api\PostController::class, 'tags']);
Route::get('/posts/popular', [\SenolDogan\AdminPanel\Http\Controllers\Api\PostController::class, 'popular']);
Route::get('/posts/recent', [\SenolDogan\AdminPanel\Http\Controllers\Api\PostController::class, 'recent']); 