<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user', function () {
    return view('new-user');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/update', function () {
    return view('user-update');
});

