<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class ProviderController extends Controller
{
    public function redirect(string $provider)
    {
        //send the user's request to oauth1 github or google
        return Socialite::driver($provider)->stateless()->redirect();
    }
    public function callback(string $provider)
    {
        try{
            //get oauth request back from github to authenticate the user
            $json = Socialite::driver($provider)->stateless()->user();

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

            return response()->json([
                'access_token' => $user->createToken($provider . 'token')->plainTextToken ,
            ]);
        }catch(Throwable $e){
            return response()->json([
                'provider' => $provider ,
                'error' => 'failed to authenticate the user with ' .$provider.' account' ,
                'message' => $e->getMessage() ,
            ]);
        }
    }
}
