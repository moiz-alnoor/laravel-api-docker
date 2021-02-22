<?php

namespace App\Http\Controllers;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function read(){
        $grade = Grade::all();
        if($grade)
        return response()->json($grade);
    }
}
