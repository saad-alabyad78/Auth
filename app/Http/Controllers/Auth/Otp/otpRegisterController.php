<?php

namespace App\Http\Controllers\Auth\Otp;

use Carbon\Carbon;
use App\Models\User;
use App\Traits\GmailOtp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\VerifyEmailRequest;

class otpRegisterController extends Controller
{
    use GmailOtp;

    public function register(RegisterRequest $request)
    {
        //password hashed in the model
        $user = User::create($request->validated());

        $this->fulfill($user , ' this is your verification code ');

        return response()->json([
            'message' => 'otp verification code has been sent to ' . $user->email
            ] , 201);
    }

    public function verify(VerifyEmailRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email' , $validated['email'])->first() ;

        $ok = $this->verifyOtp($user , $validated['email_otp_code']);

        if(!$ok)
        {
            return response()->json([
                'error' => ' try again please' ,
            ]);
        }

        return response()->json([
            'message' => 'user email has been verified successfully ' ,
        ]) ;
    }
}
