<?php

use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;

Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::middleware(['guest:admin'])->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
    });

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/index', [HomeController::class, 'index'])->name('index');
        Route::get('/user-list', [HomeController::class, 'showUsers'])->name('user-list');
        Route::get('/link-list', [HomeController::class, 'showLinks'])->name('link-list');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});