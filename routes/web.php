<?php

use Illuminate\Support\Facades\Route;

// Le decimos a Laravel que al entrar a la raíz (/) nos muestre la vista 'login'
Route::get('/', function () {
    return view('login');
})->name('login');
// Ruta para mostrar el chat después de iniciar sesión exitosamente
Route::get('/chat', function () {
    return view('chat');
})->name('chat');

// Ruta para mostrar la vista de recuperar contraseña
Route::get('/olvide-mi-contrasena', function () {
    return view('forgot-password');
})->name('password.request');