<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
    Route::post('/refresh', 'refresh');
    Route::post('/me', 'me');
});

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('users', UserController::class)->except(['store', 'update']);
    Route::patch('users/{user}', [UserController::class, 'update']);
});

Route::post('users', [UserController::class, 'store']);
Route::post('users/{user}/avatar', [UserController::class, 'updateAvatar']);