<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{ 
    private $isVerified = 'true';
    public function userType(Request $request){
        
           $user = User::where('is_verified', $this->isVerified)
                    ->where('phone_number', '+'.$request->phone_number)
                    ->update(['user_type_id' => $request->user_type_id]);
                      if($user) 
                        return response()->json($user, 200);
            }
}
