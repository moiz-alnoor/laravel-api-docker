<?php

namespace App\Http\Controllers;
use App\Models\BookedClass;
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
        ->join('teacher_location_availability', 'teacher_location_availability.id', '=', 'booked_class.teacher_location_availability_id')
        ->join('teacher_time_availability', 'teacher_time_availability.id', '=', 'booked_class.teacher_time_availability_id')
        ->where('teacher_time_availability.date', '<', date('Y-m-d'))
        ->get(['user.name',
               'subject.subject',
               'teacher_location_availability.longitude',
               'teacher_location_availability.latitude',
               'teacher_time_availability.date',
               'teacher_time_availability.from',
               'teacher_time_availability.to'
               ]);
        if($pastClass)
        return response()->json($pastClass); 

    }

    public function oneClass(Request $request, $id){
       //getting one  class
        $oneclass = BookedClass::join('select_subject', 'select_subject.id', '=', 'booked_class.select_subject_id')
        ->join('user', 'user.phone_number', '=', 'select_subject.user_phone_number')
        ->join('subject', 'subject.id', '=', 'select_subject.subject_id')
        ->join('teacher_location_availability', 'teacher_location_availability.id', '=', 'booked_class.teacher_location_availability_id')
        ->join('teacher_time_availability', 'teacher_time_availability.id', '=', 'booked_class.teacher_time_availability_id')
        ->join('dialog', 'dialog.booked_class_id', '=', 'booked_class.id')
        ->where('booked_class.id',$id)
        ->get(['user.name',
               'subject.subject',
               'teacher_location_availability.longitude',
               'teacher_location_availability.latitude',
               'teacher_time_availability.date',
               'teacher_time_availability.from',
               'teacher_time_availability.to',
               'dialog.message',
               'dialog.time',
               'dialog.date'
               ]);
        if($oneclass)
        return response()->json($oneclass); 
}}
