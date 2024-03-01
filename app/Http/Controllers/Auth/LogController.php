<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LogInRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class LogController extends Controller
{
    public function login(LogInRequest $request)
    {
        //TODO: the otp code must be when loggin in not when register
        //what if log in with not verefied email

        $user = User::where('email' , $request->email)->first();

       if(!$user || !Hash::check($request->password , $user->password)){
            return response()->json([
                'error' => 'the provided credentials are incorrect :(' ,
            ]);
        }

        if(!!! $user->email_verified_at){
            return response()->json([
                'error'=> 'you need to verify your email' ,
            ]);
        }

        $device = substr($request->userAgent() ?? '' , 0 , 255) ;

        return response()->json([
            'access_token' => $user->createToken($device)->plainTextToken ,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
}
