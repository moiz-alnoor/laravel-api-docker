<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function userType(Request $request, $user_id)
    {

        $user = User::find($user_id);
        $user->user_type = $request->user_type_id;
        $user->save();
        if ($user) {
            return response()->json($user, 200);
        }

    }
    public function setPlayerId(Request $request, $user_id)
    {

        $user = User::find($user_id);
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
