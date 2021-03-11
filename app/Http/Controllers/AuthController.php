<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

/* DOCs
   https://www.positronx.io/laravel-jwt-authentication-tutorial-user-login-signup-api/
   https://www.twilio.com/blog/verify-phone-numbers-php-laravel-application-twilio-verify
*/
class AuthController extends Controller{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'signIn', 'register', 'verify', 'logout', 'userProfile']]);
    }


    public function register(Request $request)
    {

        $data = $request->validate([
            'phone_number' => ['required'],
            'country_code' => ['required'],
        ]);

        $user = user::where('phone_number', $data['phone_number'])->first();

        if (!is_object($user)) {
            /* if uer has not account */
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);
            $twilio->verify->v2->services($twilio_verify_sid)
                ->verifications
                ->create('+' . $request->country_code . $data['phone_number'], "sms");
            //random id
            //$uniques = range(10000, 99999);
            //shuffle($uniques);
            //$uniques = array_slice($uniques, 0, 500);
            $user = User::create([
                'id' => mt_rand(),
                'name' => 'user',
                'phone_number' => $data['phone_number'],
                'password' => bcrypt(':)'),
                'is_verified' => false,
            ]);
            return response()->json([
                'message' => 'User successfully registered',
                'user' => $user,
            ], 201);

        } else {
            /* if uer has exist account just sent otp */
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);
            $twilio->verify->v2->services($twilio_verify_sid)
                ->verifications
                ->create('+' . $request->country_code . $data['phone_number'], "sms");
            return response()->json([
                'message' => 'User exist, just verify your phone',
                'user' => $user,
            ], 201);

        }

    }

 
    public function verify(Request $request)
    {
        /*  validatee input  */
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
            'country_code' => ['required'],
        ]);

        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($data['verification_code'], array('to' => '+' . $request->country_code . $data['phone_number']));
        if ($verification->valid) {
            $user = tap(User::where('phone_number', $data['phone_number']))->update(['is_verified' => true]);
            if (!$token = auth()->attempt(['phone_number' => $request->phone_number, 'password' => ':)'])) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->createNewToken($token);
        }
        return response()->json([
            'message' => 'Invalid verification code entered!',
        ], 201);
    }

    public function logout(Request $request, $user_id)
    {

        $user = User::where('id', $user_id)
            ->update(['is_verified' => false]);
        if ($user) {
            auth()->logout();
            return response()->json(['message' => 'User successfully signed out']);
        }

    }

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

 
     
    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token)
    {

        return response()->json([
            'message' => 'Phone number verified',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 360,
            'user' => auth()->user(),
        ]);
    }
}
