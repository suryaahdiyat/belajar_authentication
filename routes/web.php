<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/login', [LoginController::class, 'loginV'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::get('/register', [LoginController::class, 'registerV'])->name('register')->middleware('guest');
Route::post('/register', [LoginController::class, 'register'])->middleware('guest');

Route::post('/logout', [LoginController::class,'logout'])->name('logout')->middleware('auth');
