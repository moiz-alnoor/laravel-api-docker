<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function create(Request $request){
        $subject = new Subject();
        $subject->subject = $request->subject;
        $subject->save();
        return response()->json($subject, 201);
    }
    
    public function readAll(){
        $subject = Subject::all();
        return response()->json($subject);
    }

    public function readOne(Request $request, $id){
        $subject = Subject::find($id);
        return response()->json($subject);
    }

    public function update(Request $request, $id){
        $subject = Subject::find($id);
        $subject->subject = $request->subject;
        $subject->save();
    }

    public function delete(Request $request, $id){
        Subject::destroy($id);
        return response()->json(null, 204);
    }
}
