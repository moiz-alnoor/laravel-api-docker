<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Badge;
use App\Models\BookedClass;
use App\Models\Requirement;
use App\Models\SelectSubject;

class BadgeController extends Controller
{

 

    public function read(Request $request,$user_id){
        $badge = SelectSubject::leftJoin('subject', 'subject.id', '=', 'select_subject.subject_id')
        ->leftJoin('grade', 'grade.id', '=', 'select_subject.grade_id')
        ->distinct()
        ->where('user_id',$user_id)
        ->get();
        if($badge)
        return response()->json($badge,200); 
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
