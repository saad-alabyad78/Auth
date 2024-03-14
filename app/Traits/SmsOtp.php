<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

trait SmsOtp
{
    protected int $minutes = 60 ;

    protected function fulfill(User $user , string $message){
        $code = $this->generate(4) ;
        $this->set($user , $code );
        return $this->send($user , $code , $message );
    }
    protected function verifyOtp(User $user , string $otp){
        if
        (Hash::check($otp , $user->phone_number_otp_code) and $user->phone_number_otp_expired_date >= Carbon::now())
        {
            $user->phone_number_verified_at = Carbon::now() ;
            $user->save();
            return true;
        }
        return false;
    }

    protected function generate(int $digits){
        return rand(pow(10 , $digits-1) , pow(10 , $digits)-1) ;
    }

    protected function set(User $user , int $otp ){
        $user->phone_number_otp_code = Hash::make($otp);
        $user->phone_number_otp_expired_date = Carbon::now()->addMinutes($this->minutes);
        $user->save();
    }

    protected function send(User $user , int $otp , $message){
        
        $key = config('sms.gateway.api_key');
        $url = config('sms.gateway.url');

            $response = Http::withHeaders([
                'Authorization' => $key,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                // Add any additional headers as needed
            ])->post($url, [
                // Add your request body here
                "message" => "$message $otp" ,
                "to" => $user->phone_number ,
            ]);

        return $response ;

    }
}


