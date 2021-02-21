<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use App\Models\TeacherTimeAvailability;
use App\Models\TeacherDateAvailability;
use App\Models\CreateClass;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function timeAvailability(Request $request){
        //set time available
        $teacher = new TeacherTimeAvailability();
        $teacher->from = $request->from;
        $teacher->to = $request->to;
        $teacher->user_phone_number = $request->teacher_phone_number;
        $teacher->save();
        if($teacher)
        return response()->json($teacher, 201);
    }
    
    public function dateAvailability(Request $request){
        //set date available
        $teacher = new TeacherDateAvailability();
        $teacher->date = $request->date;
        $teacher->user_phone_number = $request->teacher_phone_number;
        $teacher->save();
        if($teacher)
        return response()->json($teacher, 201);
    }

    public function charge(Request $request){
        //teacher charge per hour
        $teacher = new Charge();
        $teacher->user_phone_number = $request->teacher_phone_number;
        $teacher->amount = $request->amount;
        $teacher->save();
        if($teacher)
        return response()->json($teacher, 201); 
    }

    public function profile(){ 
        //getting teacher profile
        $teacherProfile = Teacher::join('rating', 'rating.user_phone_number', '=', 'user.phone_number')
        ->join('charging_hours', 'charging_hours.user_phone_number', '=', 'rating.user_phone_number')
        ->get(['user.*', 'charging_hours.amount', 'rating.rating']);
        if($teacherProfile)
        return response()->json($teacherProfile); 
    }

    public function teacherClassList(Request $request, $user_phone_number){
        //getting teacher classes based on status
        $class = CreateClass::join('class_location', 'class_location.id', '=', 'create_class.class_location_id')
        ->join('class_time', 'class_time.id', '=', 'create_class.class_time_id')
        ->join('teacher_subject', 'teacher_subject.id', '=', 'create_class.teacher_subject_id')
        ->join('subject', 'subject.id', '=', 'teacher_subject.subject_id')
        ->join('grade', 'grade.id', '=', 'teacher_subject.grade_id')
        ->where('teacher_subject.user_phone_number' , $user_phone_number)
        ->get();
        if($class)
        return response()->json($class); 
    }
  
}

