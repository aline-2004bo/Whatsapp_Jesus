<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\CustomLoginController;

/*
|--------------------------------------------------------------------------
| Ruta principal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login',[CustomLoginController::class,'showLoginForm'])->name('login');

Route::post('/login',[CustomLoginController::class,'login']);

Route::post('/logout',[CustomLoginController::class,'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| REGISTRO
|--------------------------------------------------------------------------
*/

Route::get('/register',[CustomLoginController::class,'showRegisterForm'])->name('register');

Route::post('/register',[CustomLoginController::class,'register'])->name('register.store');


/*
|--------------------------------------------------------------------------
| RECUPERAR CONTRASEÑA
|--------------------------------------------------------------------------
*/

Route::get('/password/request',[CustomLoginController::class,'showForgotForm'])->name('password.request');

Route::post('/password/email',[CustomLoginController::class,'sendNewPassword'])->name('password.email');


/*
|--------------------------------------------------------------------------
| Rutas protegidas
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/chat',[ChatController::class,'index'])->name('chat');

    Route::get('/messages/{id}',[ChatController::class,'messages']);

    Route::post('/send',[ChatController::class,'send']);

    Route::get('/profile',[ProfileController::class,'edit'])->name('profile.edit');

    Route::patch('/profile',[ProfileController::class,'update'])->name('profile.update');

    Route::delete('/profile',[ProfileController::class,'destroy'])->name('profile.destroy');

});