<?php

use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => ['guest','signed'] ,
],function () {
    Route::post('forgot-password' , [PasswordController::class , 'forgotPassword'])
        ->name('password.email');


    Route::post('reset-password/{token}' , [PasswordController::class , 'resetTokens'])
        ->middleware('signed')
        ->name('password.reset');


    Route::post('/reset-password', [PasswordController::class , 'resetPassword'])
        ->name('password.update');
});
