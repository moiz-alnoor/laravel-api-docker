<?php

namespace App\Http\Controllers;
use App\Models\BookedClass;
use App\Models\TeacherTimeAvailability;
use App\Models\TeacherLocationAvailability;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function studentTeacher(Request $request, $user_phone_number){
        // getting teachers who teach this student
        $studentTeacher = BookedClass::leftJoin('select_subject', 'select_subject.subject_id', '=', 'booked_class.select_subject_id')
        ->leftJoin('user', 'user.phone_number', '=', 'select_subject.user_phone_number')
        ->where('booked_class.user_phone_number' , $user_phone_number)
        ->get();
        if($studentTeacher)
        return response()->json($studentTeacher); 
}

    public function pickDate(Request $request, $user_phone_number){
         // pick suitable time to studey
        $pickDate = TeacherTimeAvailability::where('user_phone_number' , $user_phone_number)
        ->get(['teacher_time_availability.date']);
        if($pickDate)
        return response()->json($pickDate); 
}
    public function pickTime(Request $request, $date, $user_phone_number){
        // pick suitable time to studey
        $pickTime = TeacherTimeAvailability::where('user_phone_number', $user_phone_number)->where('date', $date)
        ->get();
        if($pickTime)
        return response()->json($pickTime); 
}
    public function aboutLocation(Request $request, $user_phone_number){
        // pick suitable time to studey
        $aboutLocation = TeacherLocationAvailability::where('user_phone_number', $user_phone_number)
        ->get();
        if($aboutLocation)
        return response()->json($aboutLocation); 
    }

}
