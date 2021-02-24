<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Charge;
use App\Models\TeacherTimeAvailability;
use App\Models\TeacherLocationAvailability;
use App\Models\BookedClass;
use App\Models\SelectSubject;

class TeacherController extends Controller
{
    public function timeAvailability(Request $request){
        //set time available
        $teacher = new TeacherTimeAvailability();
        $teacher->from = $request->from;
        $teacher->to = $request->to;
        $teacher->date = $request->date;
        $teacher->user_phone_number = '+'.$request->user_phone_number;
        $teacher->save();
        if($teacher)
        return response()->json($teacher, 201);
    }
    

    public function locationAvailability(Request $request){
        //set date available
        $loaction = new TeacherLocationAvailability();
        $loaction->user_phone_number = '+'.$request->user_phone_number;
        $loaction->longitude = $request->longitude;
        $loaction->latitude = $request->latitude;
        $loaction->save();
        if($loaction)
        return response()->json($loaction, 201);
    }

    public function charge(Request $request){
        //teacher charge per hour
        $teacher = new Charge();
        $teacher->user_phone_number = '+'.$request->user_phone_number;
        $teacher->amount = $request->amount;
        $teacher->save();
        if($teacher)
        return response()->json($teacher, 201); 
    }

    public function choseTeacher(Request $request, $subject_id, $grade_id){ 
        // getting teacher based chosen subject and grade 
        $choseTeacher = SelectSubject::join('user', 'user.phone_number', '=', 'select_subject.user_phone_number')
        ->join('subject', 'subject.id', '=', 'select_subject.subject_id')
        ->join('grade', 'grade.id', '=', 'select_subject.grade_id')
        ->where('select_subject.subject_id', $subject_id)
        ->where('select_subject.grade_id', $grade_id)
        ->get(['user.name',
               'subject.subject',
               'user.image_location']);
        if($choseTeacher)
         //$rating = Rating::where('user_phone_number','+'.$request->user_phone_number)->get();
         //$charge = Charge::where('user_phone_number','+'.$request->user_phone_number)->get();
         //if(count($rating) > 0  and count($charge) > 0){
        return response()->json($choseTeacher); 

}

    public function teacherStudent(Request $request, $user_phone_number){
        //getting teacher student who teach
        $teacherStudent = BookedClass::join('user', 'user.phone_number', '=', 'booked_class.user_phone_number')
        ->join('select_subject', 'select_subject.id', '=', 'booked_class.select_subject_id')
        ->where('select_subject.user_phone_number' , $user_phone_number)
        ->get(['user.*']);
        if($teacherStudent)
        return response()->json($teacherStudent); 
    }
    
  
}

