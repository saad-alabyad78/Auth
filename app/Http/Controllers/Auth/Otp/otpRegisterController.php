<?php

namespace App\Http\Controllers\Auth\Otp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Traits\myOtp;
use Carbon\Carbon;
use Illuminate\Http\Request;

class otpRegisterController extends Controller
{
    use myOtp;

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        //password hashed in the model

        $user = User::create($data);

        $this->fulfill($user);

        return response()->json($user, 201);
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'otp_code' => 'required|string',
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email' , $validated['email'])->first() ;

        $ok = $this->verifyOtp($user , $validated['otp_code']);

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
