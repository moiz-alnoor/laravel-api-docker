<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;

class UserController extends Controller
{ 
    public function userType(Request $request, $user_id){

        $user = User::find($user_id);
        $user->user_type = $request->user_type_id;
        $user->save();
        if($user)
        return response()->json($user, 200);
    }
}