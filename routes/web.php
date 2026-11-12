<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;

Route::middleware('guest')->group(function () {
    Route::get('/', [UsuariosController::class, 'showLogin'])->name('login');
    Route::post('/login', [UsuariosController::class, 'login'])->name('login.post');

    Route::get('/register', [UsuariosController::class, 'create'])->name('register');
    Route::post('/register', [UsuariosController::class, 'store'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UsuariosController::class, 'index'])->name('dashboard');
    Route::post('/logout', [UsuariosController::class, 'logout'])->name('logout');
});
