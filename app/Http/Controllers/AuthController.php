<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

// DOCs
// https://www.positronx.io/laravel-jwt-authentication-tutorial-user-login-signup-api/
// https://www.twilio.com/blog/verify-phone-numbers-php-laravel-application-twilio-verify
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'signIn', 'register', 'verify', 'logout', 'userProfile']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(Request $request)
    {

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric', 'unique:users'],
            'country_code' => ['required'],
            // 'password' => ['required', 'string'],
        ]);

        /*  Get credentials from .env  */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create('+' . $request->country_code . $data['phone_number'], "sms");
        $userOut = UserOut::where('phone_number', $data['phone_number'])->first();
        if ($userOut) {
            $user = User::create([
                'name' => $userOut->name,
                'phone_number' => $userOut->phone_number,
                'password' => bcrypt(':)'),
                'is_verified' => false,
            ]);
        } else {
            $user = User::create([
                'name' => $data['name'],
                'phone_number' => $data['phone_number'],
                'password' => bcrypt(':)'),
                'is_verified' => false,
            ]);
        }

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function verify(Request $request)
    {

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

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout(Request $request, $user_id)
    {
        auth()->logout();

        //
        $user = User::find($user_id);

        //
        $userOutDelete = UserOut::destroy($user_id);

        //
        $addUserOut = new UserOut();
        $addUserOut->name = $user->name;
        $addUserOut->phone_number = $user->phone_number;
        $addUserOut->password = bcrypt(':)');
        $addUserOut->is_verified = false;
        $addUserOut->save();

        if ($addUserOut) {
            $user->forceDelete();
            return response()->json(['message' => 'User successfully signed out']);
        }
    }

    public function signIn(Request $request)
    {

        $data = $request->validate([
            'phone_number' => ['required', 'numeric', 'unique:users'],
            'country_code' => ['required'],
            // 'password' => ['required', 'string'],
        ]);

        /*  Get credentials from .env  */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create('+' . $request->country_code . $data['phone_number'], "sms");
        //$user = tap(User::where('phone_number', $request->phone_number))->update(['is_verified' => true]);

        /*$user = User::where('phone_number', $request->phone_number)->first();
        if ($user) {
        $user = User::find($user->id);
        $user->is_verified = true;
        $user->save();
        return $user;
         */

        return response()->json([
            'message' => 'User successfully registered',
            //    'user' => $user,
        ], 201);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {

        return response()->json([
            'message' => 'Phone number verified',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ]);
    }
}
