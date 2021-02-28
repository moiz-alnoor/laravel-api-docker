<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\SelectSubject;

class SubjectController extends Controller
{
    public function create(Request $request){
        $subject = new Subject();
        $subject->subject = $request->subject;
        $subject->save();
        if($subject)
        return response()->json($subject, 201);
    }
    
    public function read(){
        $subject = Subject::all();
        if($subject)
        return response()->json($subject);
    }

    public function readOne(Request $request, $id){
        $subject = Subject::find($id);
        if($subject)
        return response()->json($subject);
    }

    public function update(Request $request, $id){
        $subject = Subject::find($id);
        $subject->subject = $request->subject;
        $subject->save();
        if($subject)
        return response()->json($subject, 200);
    }

    public function delete(Request $request, $id){
        $subject = Subject::destroy($id);
        if($subject)
        return response()->json(null, 204);
    }
    public function selectSubject(Request $request){
        $subject = new SelectSubject();
        $subject->teacher_phone_number = '+'.$request->teacher_phone_number;
        $subject->subject_id = $request->subject_id;
        $subject->grade_id = $request->grade_id;
        $subject->save();
        if($subject)
        return response()->json($subject, 201); 
    }
}
