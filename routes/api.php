<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
    Route::post('/refresh', 'refresh')->name('refresh');
    Route::post('/me', 'me')->name('me');
});

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('users', UserController::class)->except(['store', 'update']);
    Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update');
});

Route::post('users', [UserController::class, 'store'])->name('users.store');