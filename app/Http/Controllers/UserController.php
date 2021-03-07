<?php

namespace App\Http\Controllers;
use App\Models\UserType;
use Illuminate\Http\Request;

class UserController extends Controller
{ 
    public function userType(Request $request){

           $user_type =  $user_type = new UserType();
                    $user_type->type = $request->type;
                    $user_type->user_id = $request->user_id;
                    $user_type->save();
                    if($user_type) 
                    return response()->json($user_type, 200);
                }
}
