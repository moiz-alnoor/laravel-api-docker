<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Teacher;
use App\Models\TeacherTimeAvailability;
use App\Models\TeacherDateAvailability;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function timeAvailability(Request $request){
        $teacher = new TeacherTimeAvailability();
        $teacher->from = $request->from;
        $teacher->to = $request->to;
        $teacher->user_phone_number = $request->teacher_phone_number;
        $teacher->save();
        if($teacher)
        return response()->json($teacher, 201);
    }
    
    public function dateAvailability(Request $request){
        $teacher = new TeacherDateAvailability();
        $teacher->date = $request->date;
        $teacher->user_phone_number = $request->teacher_phone_number;
        $teacher->save();
        if($teacher)
        return response()->json($teacher, 201);
    }

    public function charge(Request $request){
        $teacher = new Charge();
        $teacher->user_phone_number = $request->teacher_phone_number;
        $teacher->amount = $request->amount;
        $teacher->save();
        if($teacher)
        return response()->json($teacher, 201); 
    }

    public function TeacherProfile(){ 
    return $x = Teacher::find('+9710553239521')->teacherCharge;
       
    }

  
}

