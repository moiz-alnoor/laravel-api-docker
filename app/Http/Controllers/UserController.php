<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Charge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function userType(Request $request,$user_type_id)
    {
       $user = auth()->user();
       $userType = User::find($user->id);
        $userType->user_type = $user_type_id;
        $userType->save();
        if ($userType) {
            return response()->json($userType, 200);
        }

    }
    public function setPlayerId(Request $request, $player_id)
    {

        $user = auth()->user();
        $user = User::find($user->id);
        $user->player_id = $player_id;
        $user->save();
        if ($user) {
            return response()->json($user, 200);
        }

    }

    public function userEdit(Request $request, $user_type_id)
    {

        $user = auth()->user();

        if($user_type_id == 1){
        $user = User::find($user->id);
        //Storage::delete($user->image_location);
        //$path = $request->file('file')->store('user_img');
        $user->name = $request->name;
        $user->save();
        if ($user) {
            return response()->json($user, 200);
        }
} else
        $user = User::find($user->id); 
        $user->name = $request->name;
        $user->save();
             $charge = Charge::where('user_id', $user->id)->update(['amount' => $request->amount]);
         

        if ($charge) {
            return response()->json($user, $charge,  200);
        }
    }

    public function read(Request $request, $user_type_id){
    $user = auth()->user();
      if($user_type_id == 1){
     
        $user = User::find($user->id);
        if ($user) {
        return response()->json($user, 200);
        }
    }  else

    $user = User::with(['charge'])->where('users.id', $user->id)->get();
        if ($user) {
        return response()->json($user, 200);
        }
   }
}