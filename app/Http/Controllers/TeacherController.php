<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\TeacherTimeAvailability;
use App\Models\TeacherDateAvailability;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function timeAvailability(Request $request){
        $teacher = new TeacherTimeAvailability();
        $teacher->from = $request->from;
        $teacher->to = $request->to;
        $teacher->teacher_phone_number = $request->teacher_phone_number;
        $teacher->save();
        return response()->json($teacher, 201);
    }
    
    public function dateAvailability(Request $request){
        $teacher = new TeacherDateAvailability();
        $teacher->date = $request->date;
        $teacher->teacher_phone_number = $request->teacher_phone_number;
        $teacher->save();
        return response()->json($teacher, 201);
    }

    public function charge(Request $request){
        
       // setlocale(LC_MONETARY, 'en_US');
        $teacher = new Charge();
        $teacher->teacher_phone_number = $request->teacher_phone_number;
        $teacher->amount = number_format($request->amount,2);
        $teacher->save();
        return response()->json($teacher, 201);
    }

}
