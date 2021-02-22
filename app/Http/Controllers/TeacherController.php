<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use App\Models\TeacherTimeAvailability;
use App\Models\TeacherDateAvailability;
use App\Models\TeacherLocationAvailability;
use App\Models\BookedClass;
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

    public function locationAvailability(Request $request){
        //set date available
        $loaction = new TeacherLocationAvailability();
        $loaction->user_phone_number = $request->date;
        $loaction->longitude = $request->longitude;
        $loaction->latitude = $request->latitude;
        $loaction->save();
        if($loaction)
        return response()->json($loaction, 201);
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
        ->where('user.user_type_id' , 1)
        ->get(['user.*', 'charging_hours.amount', 'rating.rating']);
        if($teacherProfile)
        return response()->json($teacherProfile); 
    }

 
    
    public function teacherStudent(Request $request, $user_phone_number){
        //getting teacher classes based on status
       //return $user_phone_number;
        $class = BookedClass::join('user', 'user.phone_number', '=', 'booked_class.user_phone_number')
        ->where('booked_class.user_phone_number' , $user_phone_number)
        ->get(['user.*']);
        if($class)
        return response()->json($class); 
    }
    
  
}

