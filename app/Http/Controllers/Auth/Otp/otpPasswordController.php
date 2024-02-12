<?php

namespace App\Http\Controllers\Auth\Otp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use App\Traits\myOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class otpPasswordController extends Controller
{
    use myOtp;

    public function forgotPassword(ForgotPasswordRequest $request){
        $user = User::where('email' , $request->validated()['email'])->first();
        $this->fulfill($user , 'Enter the code to reset your password');
    }

    public function resetPassword(Request $request) {

        $validated = $request->validate(
            [
                'email' => 'required|email|exists:users,email' ,
                'password' => 'required|confirmed' ,
                'otp_code' => 'required|string' ,
            ]
        );

        $user = User::where('email' , $validated['email'])->first();

        $ok = $this->verifyOtp($user , $validated['otp_code']);

        if(!$ok)
        {
            return response()->json([
                'error' => ' try again pleas' ,
            ]);
        }

        //TODO : test there is no double hashing from the model

        $user->password = Hash::make($validated['password']) ;
        $user->save();

        return response()->json([
            'message' => 'new password was updated successfully ' ,
        ]) ;

    }

}
