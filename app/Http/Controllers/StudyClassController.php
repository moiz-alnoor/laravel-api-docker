<?php

namespace App\Http\Controllers;
use App\Models\ClassLocation;
use App\Models\ClassTime;
use App\Models\createClass;
use Illuminate\Http\Request;

class StudyClassController extends Controller
{
    public function location(Request $request){
        //set location available
        $location = new ClassLocation();
        $location->create_class_id = $request->create_class_id;
        $location->longitude = $request->longitude;
        $location->latitude = $request->latitude;
        $location->save();
        if($location)
        return response()->json($location, 201);

    }

    public function time(Request $request){
        //set time available
        $time = new ClassTime();
        $time->create_class_id = $request->create_class_id;
        $time->start_time = $request->start_time;
        $time->end_time = $request->end_time;
        $time->date = $request->date;
        $time->save();
        if($time)
        return response()->json($time, 201);

    }
    public function create(Request $request){
        //teacher charge for class per hour
        $teacher = new createClass();
        $teacher->class_location_id = $request->class_location_id;
        $teacher->class_time_id = $request->class_time_id;
        $teacher->teacher_subject_id = $request->teacher_subject_id;
        $teacher->class_status_id = $request->class_status_id;
        $teacher->save();
        if($teacher)
        return response()->json($teacher, 201); 
    }

    public function upComingClass(Request $request){
        //getting up coming class
        $upComingclass = CreateClass::join('class_location', 'class_location.id', '=', 'create_class.class_location_id')
        ->join('class_time', 'class_time.id', '=', 'create_class.class_time_id')
        ->join('teacher_subject', 'teacher_subject.id', '=', 'create_class.teacher_subject_id')
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
