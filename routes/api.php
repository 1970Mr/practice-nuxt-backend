<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')
    ->middleware('auth:sanctum');

Route::post('auth/validate-token', [AuthController::class, 'validateToken'])
    ->middleware('auth:sanctum');

Route::apiResource('posts', PostController::class)
    ->only(['index', 'show']);

Route::apiResource('posts', PostController::class)
//    ->only(['store', 'update', 'destroy'])
    ->only(['store', 'destroy'])
    ->middleware('auth:sanctum');

Route::post('posts/{post}', [PostController::class, 'update'])
    ->middleware('auth:sanctum');
