<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookedClass;
use App\Models\Charge;
use App\Models\SelectSubject;
use App\Models\Teacher;
use App\Models\Review;
use App\Models\TeacherLocationAvailability;
use App\Models\TeacherTimeAvailability;


class TeacherController extends Controller
{
    public function timeAvailability(Request $request)
    {
        $user = auth()->user();
        $teacher = new TeacherTimeAvailability();
        $teacher->from =  date("H:i A");
        $teacher->to = $request->to;
        $teacher->date = $request->date;
        $teacher->user_id = $user->id;
        $teacher->save();
        if ($teacher) {
            return response()->json($teacher, 201);
        }

    }

    public function locationAvailability(Request $request)
    {
        // set date available
        $user = auth()->user();
        $loaction = new TeacherLocationAvailability();
        $loaction->user_id = $user->id;
        $loaction->longitude = $request->longitude;
        $loaction->latitude = $request->latitude;
        $loaction->save();
        if ($loaction) {
            return response()->json($loaction, 201);
        }

    }

    public function charge(Request $request)
    {
        $user = auth()->user();
        $teacher = new Charge();
        $teacher->user_id = $user->id;
        $teacher->amount = $request->amount;
        $teacher->save();
        if ($teacher) {
            return response()->json($teacher, 201);
        }

    }

    public function choseTeacher(Request $request, $subject_id, $grade_id)
    {
        // getting teacher based chosen subject and grade
        $choseTeacher = SelectSubject::leftJoin('users', 'users.id', '=', 'select_subject.user_id')
            ->leftJoin('subject', 'subject.id', '=', 'select_subject.subject_id')
            ->leftJoin('grade', 'grade.id', '=', 'select_subject.grade_id')
            ->leftJoin('rating', 'rating.user_id', '=', 'users.id')
            ->leftJoin('charge', 'charge.user_id', '=', 'users.id')
            ->where('select_subject.subject_id', $subject_id)
            ->where('select_subject.grade_id', $grade_id)
            ->get(['users.name',
                'subject.subject',
                'users.image_location',
                'rating.rating',
                'charge.amount',
            ]);
        if ($choseTeacher) {
            return response()->json($choseTeacher, 200);
        }

    }

    public function teacher(Request $request)
    {
        // getting teacher profile
        $user = auth()->user();
        $ratingSum = Review::where('teacher_user_id',  $user->id)->sum('rating');
        $count = Review::where('teacher_user_id',  $user->id)->count();
        $teacher = Teacher::leftJoin('charge', 'charge.user_id','=','users.id')
        ->where('users.id',  $user->id)
        ->distinct()
        ->get(['name','image_location','amount']);
       if ($teacher) {
               return response()->json([
                'teacher' => $teacher,
                'calculatedRating' =>  $ratingSum/$count,
            ], 201);
        }

    }

    public function teacherStudent(Request $request)
    {
        // getting teacher based chosen subject and grade
           $user = auth()->user();
        $choseTeacher = BookedClass::leftJoin('users', 'users.id','=','booked_class.student_user_id')
                              ->leftJoin('dialog', 'dialog.user_id','=','booked_class.student_user_id')
           ->where('booked_class.teacher_user_id', $user->id)
        ->distinct()
        ->get(['users.image_location','users.name','dialog.message','dialog.date']);
        if ($choseTeacher) {
            return response()->json($choseTeacher, 200);
        }   

    }
    public function teacherReview(Request $request)
    {     
        $user = auth()->user();
        $teacherReview = Teacher::with(['review'])->where('users.id', $user->id)->get();
        if ($teacherReview) {
               return response()->json($teacherReview,201);
        }

    }

}
