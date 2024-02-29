<?php

use App\Http\Controllers\Auth\Otp\otpPasswordController;
use App\Http\Controllers\Auth\Otp\otpRegisterController;
use Illuminate\Support\Facades\Route;

//register with otp code

//reset password with otp


Route::group(['prefix' => 'otp' , 'middleware'=> 'throttle:10,1'] , function(){

 Route::post('register' , [otpRegisterController::class , 'register']);
 Route::post('email/verify' , [otpRegisterController::class , 'verify']);

 Route::post('forgot-password' , [otpPasswordController::class , 'forgotPassword']);
 Route::post('reset-password' , [otpPasswordController::class , 'resetPassword']);

});
