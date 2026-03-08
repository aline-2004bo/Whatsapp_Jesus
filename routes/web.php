<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\CustomLoginController;

// Redirecciona la raíz al login
Route::get('/', function () {
    return redirect('/login');
});

// Dashboard protegido
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');

// Rutas de autenticación y registro
Route::middleware(['auth'])->group(function () {

    // CHAT
    Route::get('/chat',[ChatController::class,'index'])->name('chat');
    Route::get('/messages/{id}',[ChatController::class,'messages']);
    Route::post('/send',[ChatController::class,'send']);

    // PROFILE
    Route::get('/profile',[ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class,'destroy'])->name('profile.destroy');

});

// Registro de usuario normal
Route::get('/register', [CustomLoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [CustomLoginController::class, 'register'])->name('register.store');

// Formularios de "Olvidé mi contraseña"
Route::get('/password/request', [CustomLoginController::class, 'showForgotForm'])->name('password.request');
Route::post('/password/email', [CustomLoginController::class, 'sendNewPassword'])->name('password.email');

// Registro temporal si lo quieres mantener (opcional)
Route::get('/register-temp', [CustomLoginController::class, 'showRegisterForm'])->name('register.temp');
Route::post('/register-temp', [CustomLoginController::class, 'registerTemp'])->name('register.temp.store');

require __DIR__.'/auth.php';