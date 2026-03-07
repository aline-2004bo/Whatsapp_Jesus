<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return redirect('/login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');


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

require __DIR__.'/auth.php';