<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request){

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return response()->json([
            'status' => __($status) ,
        ]);
    }

    public function resetTokens(string $token){
        return response()->json(['token' => $token]);
    }

    public function resetPassword(ResetPasswordRequest $request) {

        $status = Password::reset(

            $request->only('email', 'password', 'password_confirmation', 'token')
            ,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password,
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return response()->json([
            'status' => __($status) ,
        ]);
    }


}
