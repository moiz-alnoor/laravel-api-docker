<?php

namespace App\Http\Controllers;
use App\Models\ClassLocation;
use App\Models\ClassTime;
use App\Models\createClass;
use Illuminate\Http\Request;

class StudyClassController extends Controller
{
 
   
    public function create()
    {
        # code...
    }
    
    public function upComingClass(Request $request){
        //getting up coming class
        $upComingclass = CreateClass::join('teacher_subject', 'teacher_subject.id', '=', 'create_class.teacher_subject_id')
        ->join('user', 'user.phone_number', '=', 'teacher_subject.user_phone_number')
        ->where('class_time.date', '>=', date('Y-m-d'))
        ->get();
        if($upComingclass)
        return response()->json($upComingclass); 

    }

    public function pastClass(Request $request){
        //getting up coming class
        $upComingclass = CreateClass::join('class_location', 'class_location.id', '=', 'create_class.class_location_id')
        ->join('class_time', 'class_time.id', '=', 'create_class.class_time_id')
        ->join('teacher_subject', 'teacher_subject.id', '=', 'create_class.teacher_subject_id')
        ->join('user', 'user.phone_number', '=', 'teacher_subject.user_phone_number')
        ->where('class_time.date', '<', date('Y-m-d'))
        ->get();
        if($upComingclass)
        return response()->json($upComingclass); 

    }

    public function oneClass(Request $request, $id){
       //getting one  class
        $upComingclass = CreateClass::join('class_location', 'class_location.id', '=', 'create_class.class_location_id')
        ->join('class_time', 'class_time.id', '=', 'create_class.class_time_id')
        ->join('teacher_subject', 'teacher_subject.id', '=', 'create_class.teacher_subject_id')
        ->join( 'subject','subject.id','=', 'teacher_subject.subject_id')
        ->join( 'user','user.phone_number','=', 'teacher_subject.user_phone_number')
        ->where('create_class.id', $id)
        ->get(['subject.*','class_time.*','class_location.*','user.name']);
        if($upComingclass)
        return response()->json($upComingclass); 
}}
