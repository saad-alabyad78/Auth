<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

trait ResetPasswordOtp
{
    protected int $minutes = 60 ;

    protected function fulfill(User $user , string $message){
        $code = $this->generate(4) ;
        $this->set($user , $code );
        $this->send($user , $code , $message );
    }
    protected function verifyOtp(User $user , string $otp){
        return 
        (Hash::check($otp , $user->password_otp_code) 
        and 
        $user->password_otp_expired_date >= Carbon::now()) ;
    }

    protected function generate(int $digits){
        return rand(pow(10 , $digits-1) , pow(10 , $digits)-1) ;
    }

    protected function set(User $user , int $otp ){
        $user->password_otp_code = Hash::make($otp);
        $user->password_otp_expired_date = Carbon::now()->addMinutes($this->minutes);
        $user->save();
    }

    protected function send(User $user , int $otp , $message){
        Mail::to($user)->send(new OtpMail($otp , $message)) ;
    }
}


