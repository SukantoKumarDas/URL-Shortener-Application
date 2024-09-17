<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\UrlController;

Route::middleware('guest:web')->group(function () {
    
    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::get('/', [UrlController::class, 'index'])->name('home');
Route::get('/create-custom-url', [UrlController::class, 'showCustomUrlForm'])->name('create-custom-url');
Route::post('/create-custom-url', [UrlController::class, 'generateCustomUrl']);
Route::post('/shorten', [UrlController::class, 'shortenUrl'])->name('shorten-url');
Route::get('/{alias}', [UrlController::class, 'redirect'])->name('redirect-url');

Route::middleware('auth:web')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/index', [LoginController::class, 'index'])->name('index');
});