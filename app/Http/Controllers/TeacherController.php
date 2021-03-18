<?php

namespace App\Http\Controllers;

use App\Models\BookedClass;
use App\Models\Charge;
use App\Models\SelectSubject;
use App\Models\Teacher;
use App\Models\TeacherLocationAvailability;
use App\Models\TeacherTimeAvailability;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function timeAvailability(Request $request)
    {
        $user = auth()->user();
        $teacher = new TeacherTimeAvailability();
        $teacher->from = $request->from;
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
        $loaction = new TeacherLocationAvailability();
        $loaction->user_id = $request->user_id;
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

        $choseTeacher = Teacher::with(['charge','review'])->where('users.id', $user->id)->get();
        if ($choseTeacher) {
            return response()->json($choseTeacher, 200);
        }

    }

    public function teacherStudent(Request $request, $user_id)
    {
        // getting teacher based chosen subject and grade
        $choseTeacher = BookedClass::leftJoin('users', 'users.id', '=', 'booked_class.student_user_id')
            ->leftJoin('dialog', 'dialog.booked_class_id', '=', 'booked_class.id')
            ->where('booked_class.teacher_user_id', $user_id)
            ->distinct()
            ->get(['users.phone_number', 'users.name', 'users.user_type', 'dialog.message', 'dialog.date']);
        if ($choseTeacher) {
            return response()->json($choseTeacher, 200);
        }   

    }
    public function teacherReview(Request $request)
    {     
        $user = auth()->user();
        $teacherReview = Teacher::with(['review', 'charge'])->where('users.id', $user->id)->get();
        if ($teacherReview) {
            return response()->json($teacherReview, 200);
        }

    }

}
