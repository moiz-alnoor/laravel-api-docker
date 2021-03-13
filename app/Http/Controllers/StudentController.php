<?php

namespace App\Http\Controllers;
use App\Models\BookedClass;
use App\Models\TeacherTimeAvailability;
use App\Models\TeacherLocationAvailability;
use Illuminate\Http\Request;

class StudentController extends Controller
{
 

    public function pickDate(Request $request, $user_id){
         // pick suitable time to studey
        $pickDate = TeacherTimeAvailability::where('user_id' , $user_id)
        ->get(['teacher_time_availability.date']);
        if($pickDate)
        return response()->json($pickDate, 200); 
}
    public function pickTime(Request $request, $date, $user_id){
        // pick suitable time to studey
        $pickTime = TeacherTimeAvailability::where('user_id', $user_id)->where('date', $date)
        ->get();
        if($pickTime)
        return response()->json($pickTime, 200); 
}
    public function aboutLocation(Request $request, $user_id){
        // pick suitable time to studey
        $aboutLocation = TeacherLocationAvailability::where('user_id', $user_id)
        ->get();
        if($aboutLocation)
        return response()->json($aboutLocation, 200); 
    }

    public function studentTeacher(Request $request, $user_id){ 
        // getting teacher based chosen subject and grade 
        $choseTeacher = BookedClass::leftJoin('users', 'users.id', '=', 'booked_class.teacher_user_id')
        ->leftJoin('dialog','dialog.booked_class_id', '=' ,'booked_class.id')
        ->where('booked_class.student_user_id', $user_id)
        ->distinct()
        ->get(['users.phone_number','users.name','users.user_type','dialog.message','dialog.date']);
        if($choseTeacher)
        return response()->json($choseTeacher,200); 
    }
    public function BookedClass(Request $request)
    {
        $book = new BookedClass();
        $book->student_user_id = $request->student_user_id;
        $book->teacher_user_id = $request->teacher_user_id;
        $book->teacher_location_availability_id = $request->teacher_location_availability_id;
        $book->teacher_time_availability_id = $request->teacher_time_availability_id;
        $book->subject_id = $request->subject_id;
        $book->status_id = $request->status_id;
        $book->grade_id = $request->grade_id;
        $book->save();
        if($book)
        return response()->json($book, 201);
    }

}
