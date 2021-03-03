<?php

namespace App\Http\Controllers;

use App\Models\BookedClass;
use Illuminate\Http\Request;
use App\Models\Charge;
use App\Models\TeacherTimeAvailability;
use App\Models\TeacherLocationAvailability;
use App\Models\SelectSubject;
use App\Models\Teacher;
use App\Models\User;

class TeacherController extends Controller
{
    public function timeAvailability(Request $request){
        // set time available
        $teacher = new TeacherTimeAvailability();
        $teacher->from = $request->from;
        $teacher->to = $request->to;
        $teacher->date = $request->date;
        $teacher->teacher_phone_number = '+'.$request->teacher_phone_number;
        $teacher->save();
        if($teacher)
        return response()->json($teacher, 201);
    }
    

    public function locationAvailability(Request $request){
        // set date available
        $loaction = new TeacherLocationAvailability();
        $loaction->teacher_phone_number = '+'.$request->teacher_phone_number;
        $loaction->longitude = $request->longitude;
        $loaction->latitude = $request->latitude;
        $loaction->save();
        if($loaction)
        return response()->json($loaction, 201);
    }

    public function charge(Request $request){
        // teacher charge per hour
        $teacher = new Charge();
        $teacher->teacher_phone_number = '+'.$request->teacher_phone_number;
        $teacher->amount = $request->amount;
        $teacher->save();
        if($teacher)
        return response()->json($teacher, 201); 
    }

    public function choseTeacher(Request $request, $subject_id, $grade_id){ 
        // getting teacher based chosen subject and grade 
        $choseTeacher = SelectSubject::leftJoin('user', 'user.phone_number', '=', 'select_subject.teacher_phone_number')
        ->leftJoin('subject', 'subject.id', '=', 'select_subject.subject_id')
        ->leftJoin('grade', 'grade.id', '=', 'select_subject.grade_id')
        ->leftJoin('rating', 'rating.teacher_phone_number', '=', 'user.phone_number')
        ->leftJoin('charge', 'charge.teacher_phone_number', '=', 'user.phone_number')
        ->where('select_subject.subject_id', $subject_id)
        ->where('select_subject.grade_id', $grade_id)
        ->get(['user.name',
               'subject.subject',
               'user.image_location',
               'rating.rating',
               'charge.amount',
               ]);
        if($choseTeacher)
        return response()->json($choseTeacher,200); 

    }

    public function teacherProfile(Request $request, $teacher_phone_number){ 
        // getting teacher based chosen subject and grade 
        $choseTeacher = Teacher::with(['rating','charge'])->where('user.phone_number',$teacher_phone_number)->get();
        if($choseTeacher)
        return response()->json($choseTeacher,200); 
    }

    public function teacherStudent(Request $request, $teacher_phone_number){ 
        // getting teacher based chosen subject and grade 
        $choseTeacher = BookedClass::leftJoin('user', 'user.phone_number', '=', 'booked_class.student_phone_number')
        ->leftJoin('dialog','dialog.booked_class_id', '=' ,'booked_class.id')
        ->where('booked_class.teacher_phone_number',$teacher_phone_number)
        ->distinct()
        ->get(['user.phone_number','user.name','dialog.message','dialog.date']);
        if($choseTeacher)
        return response()->json($choseTeacher,200); 
    }

}

