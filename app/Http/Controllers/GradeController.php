<?php

namespace App\Http\Controllers;
use App\Models\Grade;
use App\Models\SelectSubject;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function read(){
        $grade = Grade::all();
        if($grade)
        return response()->json($grade, 200);
    }

    public function choseGrade(Request $request, $subject_id){
        //$choseGrade = SelectSubject::with('grade')->where('select_subject.subject_id', $subject_id)->groupby('grade.grade')->distinct()->get();
        $oneclass = SelectSubject::leftJoin('grade', 'grade.id', '=', 'select_subject.grade_id')
        ->where('select_subject.subject_id', $subject_id)
        ->distinct()
        ->get(['grade.grade']);
        if($oneclass)
        return response()->json($oneclass, 200); 
    }
}
