<?php

namespace App\Http\Controllers;

use App\Models\BookedClass;
use App\Models\ClassLocation;
use App\Models\ClassTime;
use App\Models\createClass;
use Illuminate\Http\Request;

class StudyClassController extends Controller
{
    public function upComingClass(Request $request){
       //getting up coming class
        $upComingClass = BookedClass::join('select_subject', 'select_subject.id', '=', 'booked_class.select_subject_id')
        ->join('user', 'user.phone_number', '=', 'select_subject.user_phone_number')
        ->join('subject', 'subject.id', '=', 'select_subject.subject_id')
        ->join('teacher_time_availability', 'teacher_time_availability.id', '=', 'booked_class.teacher_time_availability_id')
        ->join('teacher_location_availability', 'teacher_location_availability.id', '=', 'booked_class.teacher_location_availability_id')
        ->where('teacher_time_availability.date', '>', date('Y-m-d'))
        ->get(['user.name',
               'subject.subject',
               'teacher_location_availability.longitude',
               'teacher_location_availability.latitude',
               'teacher_time_availability.date',
               'teacher_time_availability.from',
               'teacher_time_availability.to',
               ]);
        if($upComingClass)
        return response()->json($upComingClass); 

    }

    public function pastClass(Request $request){
        //getting pastClass  class for student
        $pastClass = BookedClass::join('select_subject', 'select_subject.id', '=', 'booked_class.select_subject_id')
        ->join('user', 'user.phone_number', '=', 'select_subject.user_phone_number')
        ->join('subject', 'subject.id', '=', 'select_subject.subject_id')
        ->join('teacher_time_availability', 'teacher_time_availability.id', '=', 'booked_class.teacher_time_availability_id')
        ->where('teacher_time_availability.date', '<', date('Y-m-d'))
        ->get(['user.name','subject.subject']);
        if($pastClass)
        return response()->json($pastClass); 

    }

    public function oneClass(Request $request, $id){
       //getting one  class
        $upComingclass = CreateClass::join('select_subject', 'select_subject.id', '=', 'booked_class.select_subject_id')
        ->where('booked_class.date', '<', date('Y-m-d'))
        ->get();
        if($upComingclass)
        return response()->json($upComingclass); 
}}
