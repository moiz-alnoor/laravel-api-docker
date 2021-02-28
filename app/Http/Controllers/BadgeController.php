<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Badge;

class BadgeController extends Controller
{
    public function create(Request $request){
        $badge = new Badge();
        $badge->badge = $request->badge;
        $badge->save();
        if($badge)
        return response()->json($badge, 201);
    }
    
    public function read(){
        $subject = Badge::all();
        if($subject)
        return response()->json($subject, 200);
    }
}
