<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class , 'index'])
    ->middleware('guest')
    ->name('register');

Route::get('verification/verify', [VerificationController::class, 'verify'])
    ->middleware('guest')
    ->name('verification.verify');

Route::post('/login', [LoginController::class , 'login'])
    ->middleware('guest')
    ->name('login');

Route::post('/logout', [LoginController::class , 'logout']);

