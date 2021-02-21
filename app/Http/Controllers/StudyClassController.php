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

}
