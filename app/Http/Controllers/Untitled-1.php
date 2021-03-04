<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

class AuthController extends Controller
{


    private $country_code = '+971';
    /*protected function r(Request $request){
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric', 'unique:user'],
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required','max:255'],
        ]);
        User::create([
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'password' => $data['password'],
            'country_code' => $this->country_code
            //'is_verified' => 'false',
        ]);
   
    }
    */

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    
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
            ->create($request->country_code . $data['phone_number'], "sms");
        User::create([
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'country_code' => $this->country_code
            //'is_verified' => 'false',
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
            ->create($data['verification_code'], array('to' => '+' . $request->country_code . $data['phone_number']));
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



    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
   /* public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
*/
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
