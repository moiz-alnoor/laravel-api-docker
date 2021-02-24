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
        return response()->json($grade);
    }

    public function choseGrade(Request $request, $subject_id){
        $oneclass = SelectSubject::join('grade', 'grade.id', '=', 'select_subject.grade_id')
        ->where('select_subject.subject_id', $subject_id)
        ->get(['grade.grade']);
        if($oneclass)
        return response()->json($oneclass); 
    }
}
