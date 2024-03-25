<?php

namespace App\Http\Controllers\Auth\Otp;

use App\Models\User;
use App\Traits\SmsOtp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PhoneNumberRequest;
use App\Http\Requests\Auth\VerifyPhoneNumberRequest;

class otpPhoneNumberController extends Controller
{
    use SmsOtp;
    public function register(PhoneNumberRequest $request)
    {
        $validated = $request->validated();

        //get the user
        $user = User::where("email", $validated['email'])
        ->with(('phone'))
        ->first();

        return $user;

        //store the phone number
        $user->phone->phone_number = $validated['phone_number'];
        $user->save();
        //$user->phone->save ? 

        //send sms 
        return $this->fulfill($user->phone , "pleas use the code to verify you phone number ");

        //TODO: dont return the otp code
        //return response()->json($user, 201);
    }

    public function verify(VerifyPhoneNumberRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email' , $validated['email'])->first() ;

        $ok = $this->verifyOtp($user , $validated['phone_number_otp_code']);

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
