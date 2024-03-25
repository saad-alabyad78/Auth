<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Otp\otpPasswordController;
use App\Http\Controllers\Auth\Otp\otpRegisterController;
use App\Http\Controllers\Auth\Otp\otpPhoneNumberController;

//register with otp code

//reset password with otp


Route::group(['prefix' => 'otp' , 'middleware'=> 'throttle:6,1'] , function(){

 Route::post('register' , [otpRegisterController::class , 'register']);
 Route::post('email/verify' , [otpRegisterController::class , 'verify']);

 Route::post('forgot-password' , [otpPasswordController::class , 'forgotPassword']);
 Route::post('reset-password' , [otpPasswordController::class , 'resetPassword']);

 Route::post('phone/register' , [otpPhoneNumberController::class , 'register'])
    ->middleware('throttle:2,1'); //توفير وحدات 
 Route::post('phone/verify' , [otpPhoneNumberController::class ,'verify']);
 
});
