<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    public function sign()
    {
        //send the user's request to oauth1 github
        return Socialite::driver('github')->stateless()->redirect();
    }
    public function redirect()
    {
        //get oauth request back from github to authenticate the user
        $json = Socialite::driver('github')->stateless()->user();

        if(!$json->token){
            return response()->json([
                'error' => 'some thing went wrong :(' ,
            ]);
        }

        //if the user doesn't exist , add them
        //if they do get the model .
        //either way , authenticate the user into the application

        $user = User::firstOrCreate([
            'email' => $json->email ,
        ],[
            'name' => $json->name ,
            'password' => Hash::make(Str::random(24)),
            'email' => $json->email,
        ]);

        //dd($user) ;

        return response()->json([
            'access_token' => $user->createToken('api token')->plainTextToken ,
        ]);
    }
}
