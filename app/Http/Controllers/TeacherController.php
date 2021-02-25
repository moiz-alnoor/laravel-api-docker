<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Charge;
use App\Models\TeacherTimeAvailability;
use App\Models\TeacherLocationAvailability;
use App\Models\BookedClass;
use App\Models\SelectSubject;
use App\Models\User;

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
        $choseTeacher = SelectSubject::leftJoin('user', 'user.phone_number', '=', 'select_subject.user_phone_number')
        ->leftJoin('subject', 'subject.id', '=', 'select_subject.subject_id')
        ->leftJoin('grade', 'grade.id', '=', 'select_subject.grade_id')
        ->leftJoin('rating', 'rating.user_phone_number', '=', 'user.phone_number')
        ->leftJoin('charge', 'charge.user_phone_number', '=', 'user.phone_number')
        ->leftJoin('teacher_location_availability', 'teacher_location_availability.user_phone_number', '=', 'user.phone_number')
        ->where('select_subject.subject_id', $subject_id)
        ->where('select_subject.grade_id', $grade_id)
        ->get(['user.name',
               'subject.subject',
               'user.image_location',
               'rating.rating',
               'charge.amount',
               'teacher_location_availability.longitude',
               'teacher_location_availability.latitude',
               ]);
        if($choseTeacher)
        return response()->json($choseTeacher); 

    }

    public function teacherProfile(Request $request, $user_phone_number){ 
        // getting teacher based chosen subject and grade 
        $choseTeacher = User::leftJoin('rating', 'rating.user_phone_number', '=', '.user.phone_number')
        ->leftJoin('charge', 'charge.user_phone_number', '=', 'user.phone_number')
        ->where('user.phone_number', $user_phone_number)
        ->get(['user.name',
               'user.image_location',
               'rating.rating',
               'charge.amount'
               ]);
        if($choseTeacher)
        return response()->json($choseTeacher); 

    }


    public function teacherStudent(Request $request, $user_phone_number){
        //getting this teacher  students
        $teacherStudent = BookedClass::leftJoin('user', 'user.phone_number', '=', 'booked_class.user_phone_number')
        ->leftJoin('select_subject', 'select_subject.subject_id', '=', 'booked_class.select_subject_id')
        ->where('select_subject.user_phone_number' , $user_phone_number)
        ->get(['user.*']);
        if($teacherStudent)
        return response()->json($teacherStudent); 
    }
    
  
}

