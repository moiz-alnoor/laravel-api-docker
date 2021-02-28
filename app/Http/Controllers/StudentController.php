<?php

namespace App\Http\Controllers;
use App\Models\BookedClass;
use App\Models\TeacherTimeAvailability;
use App\Models\TeacherLocationAvailability;
use Illuminate\Http\Request;

class StudentController extends Controller
{
 

    public function pickDate(Request $request, $teacher_phone_number){
         // pick suitable time to studey
        $pickDate = TeacherTimeAvailability::where('teacher_phone_number' , $teacher_phone_number)
        ->get(['teacher_time_availability.date']);
        if($pickDate)
        return response()->json($pickDate, 200); 
}
    public function pickTime(Request $request, $date, $teacher_phone_number){
        // pick suitable time to studey
        $pickTime = TeacherTimeAvailability::where('teacher_phone_number', $teacher_phone_number)->where('date', $date)
        ->get();
        if($pickTime)
        return response()->json($pickTime, 200); 
}
    public function aboutLocation(Request $request, $teacher_phone_number){
        // pick suitable time to studey
        $aboutLocation = TeacherLocationAvailability::where('teacher_phone_number', $teacher_phone_number)
        ->get();
        if($aboutLocation)
        return response()->json($aboutLocation, 200); 
    }

}
