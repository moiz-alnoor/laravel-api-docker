<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Badge;
use App\Models\Requirement;

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
    public function addRequirement(Request $request)
    {
        $requirement = new Requirement();
        $requirement->requirement = $request->requirement;
        $requirement->number = $request->number;
        $requirement->save();
        if($requirement)
        return response()->json($requirement, 201);
    }

    public function readeRequirement(){
        $requirement = Requirement::all();
        if($requirement)
        return response()->json($requirement, 200);
    }
}
