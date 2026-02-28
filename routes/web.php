<?php

use Illuminate\Support\Facades\Route;

// Le decimos a Laravel que al entrar a la raíz (/) nos muestre la vista 'login'
Route::get('/', function () {
    return view('login');
});

Route::get('/chat', function () {
    return view('chat');
});