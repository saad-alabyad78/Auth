<?php

namespace App\Http\Controllers\Auth\Otp;

use App\Models\User;
use App\Traits\GmailOtp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class otpPasswordController extends Controller
{
    use GmailOtp;

    public function forgotPassword(ForgotPasswordRequest $request){
        $user = User::where('email' , $request->validated()['email'])->first();
        $this->fulfill($user , 'Enter the code to reset your password');
    }

    public function resetPassword(ResetPasswordRequest $request) {

        $validated = $request->validateed() ;

        $user = User::where('email' , $validated['email'])->first();

        $ok = $this->verifyOtp($user , $validated['password_otp_code']);

        if(!$ok)
        {
            return response()->json([
                'error' => ' try again pleas' ,
                'email_otp_expired_date' => $user->email_otp_expired_date ,
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
