<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        //password hashed in the model

        $user = User::create($data);

        //Mail::to($user->email)->send(new WelcomeMail($user->name));

        event(new Registered($user));

        return response()->json($user, 201);
    }

    public function notice()
    {
        return response()->json([
            'error' => 'user email is not verified yet ,' ,
        ]);
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return response()->json([
            'the email verification was fulfilled successfully',
            ]) ;
    }

    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'the email verification has been sended sersuccessfully',
            ]) ;
    }
}
