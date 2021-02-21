<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Badge;

class BadgeController extends Controller
{
    public function create(Request $request){
        $subject = new Badge();
        $subject->subject = $request->subject;
        $subject->save();
        if($subject)
        return response()->json($subject, 201);
    }
    
    public function read(){
        $subject = Badge::all();
        if($subject)
        return response()->json($subject);
    }
}
