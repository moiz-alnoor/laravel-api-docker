<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

class AuthController extends Controller
{

    private $country_code = '+971';
    protected function create(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric', 'unique:user'],
        ]);
        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create('+'.$request->country_code.$data['phone_number'], "sms");
        User::create([
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'is_verified' => 'false',
        ]);


        $create = [
            "status" => "201",
            "message" => "'phone number has registered",
        ];

        return response()->json($create);
        //return redirect()->route('verify')->with(['phone_number' => $data['phone_number']]);
    
    }

    protected function verify(Request $request)
    {
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
        ]);
        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($data['verification_code'], array('to' => '+'.$request->country_code.$data['phone_number']));
        if ($verification->valid) {
            $user = tap(User::where('phone_number', $data['phone_number']))->update(['is_verified' => 'true']);
            /* Authenticate user */
            Auth::login($user->first());
            //return redirect()->route('home')->with(['message' => 'Phone number verified']);
            $verify = [
                "status" => "201",
                "details" => "phone number verified",
            ];
            return response()->json($verify);
        }
        //return back()->with(['phone_number' => $data['phone_number'], 'error' => 'Invalid verification code entered!']);
        $verify = [
            "status" => "400",
            "message" => "invalid verification code entered!",
        ];
        return response()->json($verify);
    }
}
