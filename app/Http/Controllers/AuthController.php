<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use GuzzleHttp\Psr7\Message;
use Validator;
use Twilio\Rest\Client;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'phone_number' => 'required',
            'password' => 'required',
            'verification_code' => 'required',
        ]);

        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($request['verification_code'], array('to' => '+'.$request['country_code'].$request['phone_number']));
        if ($verification->valid) {
            $user = tap(User::where('phone_number', $request['phone_number']))->update(['is_verified' => 'true']);
            /* Authenticate user */
            Auth::login($user->first());
            //return redirect()->route('home')->with(['message' => 'Phone number verified']);
            $message = [
                "status" => "201",
                "details" => "phone number verified",
            ];
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
    
            if (! $token = auth()->attempt($validator->validated())) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
    
            return $this->createNewToken($token,$message);
        }


     
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'phone_number' => 'required',
            'password' => 'required',
            'country_code' => 'required',
        
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create('+'.$request->country_code.$request['phone_number'], "sms");
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token,$message){
        return response()->json([
            'message' => $message,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

}