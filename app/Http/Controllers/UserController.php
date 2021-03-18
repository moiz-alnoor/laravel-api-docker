<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function userType(Request $request)
    {
       $user = auth()->user();
       $userType = User::find($user->id);
        $userType->user_type = $request->user_type_id;
        $userType->save();
        if ($userType) {
            return response()->json($userType, 200);
        }

    }
    public function setPlayerId(Request $request)
    {

       $user = auth()->user();
       //return $user->id;
        $user = User::find($user->id);
        $user->player_id = $request->player_id;
        $user->save();
        if ($user) {
            return response()->json($user, 200);
        }

    }

    public function setting(Request $request)
    {

        $user = User::find($request->user_id);

        Storage::delete($user->image_location);
        $path = $request->file('file')->store('user_img');

        $user->name = $request->name;
        $user->image_location = $path;
        $user->save();

        if ($user) {
            return response()->json($user, 200);
        }

    }
}
