<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;


Route::post('register' , [RegisterController::class , 'register']);

Route::post('email/verify' , [RegisterController::class , 'notice'])
    ->middleware('auth:sanctum')
    ->name('verification.notice');

Route::post('email/verify/{id}/{hash}' , [RegisterController::class , 'verify'])
    ->middleware(['auth:sanctum' , 'signed'])
    ->name('verification.verify');

Route::post('email/verification-notification' , [RegisterController::class , 'send'])
    ->middleware(['auth:sanctum' , 'throttle:6,1'])
    ->name('verification.send');





