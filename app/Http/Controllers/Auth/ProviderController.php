<?php

namespace App\Http\Controllers\Auth;

use Throwable;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class ProviderController extends Controller
{
    public function redirect(string $provider = 'google')
    {
        //send the user's request to oauth1 github or google
        return Socialite::driver($provider)->stateless()->redirect();
    }
    public function callback(string $provider)
    {
        //dd(Socialite::driver($provider)->stateless()->user());

        try{
            //get oauth request back from github to authenticate the user
            $json = Socialite::driver($provider)->stateless()->user();

            //if the user doesn't exist , add them
            //if they do get the model .
            //either way , authenticate the user into the application

            $user = User::UpdateOrCreate([
                'email' => $json->email ,
            ],[
                'name' => $json->name ,
                'password' => Hash::make(Str::random(24)),
                'email' => $json->email,
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'phone_number_verified_at' => Carbon::now()->toDateTime(),
                'email_otp_code' => 'hi',
            ]);
            $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
            $user->save();
            dd($user);
            
            return response()->json([
                'access_token' => $user->createToken($provider . '_token')->plainTextToken ,
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
