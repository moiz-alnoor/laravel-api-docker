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

    public function studentTeacher(Request $request, $student_phone_number){ 
        // getting teacher based chosen subject and grade 
        $choseTeacher = BookedClass::leftJoin('user', 'user.phone_number', '=', 'booked_class.teacher_phone_number')
        ->leftJoin('dialog','dialog.booked_class_id', '=' ,'booked_class.id')
        ->where('booked_class.teacher_phone_number', $student_phone_number)
        ->distinct()
        ->get(['user.phone_number','user.name','dialog.message','dialog.date']);
        if($choseTeacher)
        return response()->json($choseTeacher,200); 
    }
    public function book(Request $request)
    {
        $book = new BookedClass();
        $book->student_phone_number = $request->student_phone_number;
        $book->teacher_phone_number = $request->teacher_phone_number;
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
