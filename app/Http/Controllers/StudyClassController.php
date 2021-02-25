<?php

namespace App\Http\Controllers;
use App\Models\BookedClass;
use Illuminate\Http\Request;

class StudyClassController extends Controller
{

       private  $pending = 1;
       private  $approvd = 2;
       public function upComingClass(Request $request, $user_phone_number){
              //getting up coming class
              $upComingClass = BookedClass::leftJoin('select_subject', 'select_subject.id', '=', 'booked_class.select_subject_id')
              ->leftJoin('user', 'user.phone_number', '=', 'select_subject.user_phone_number')
              ->leftJoin('subject', 'subject.id', '=', 'select_subject.subject_id')
              ->leftJoin('teacher_time_availability', 'teacher_time_availability.id', '=', 'booked_class.teacher_time_availability_id')
              ->leftJoin('teacher_location_availability', 'teacher_location_availability.id', '=', 'booked_class.teacher_location_availability_id')
              ->where('teacher_time_availability.date', '>', date('Y-m-d'))
              ->where('booked_class.user_phone_number', $user_phone_number)
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

       public function pastClass(Request $request, $user_phone_number){
              //getting pastClass  class for student
              $pastClass = BookedClass::leftJoin('select_subject', 'select_subject.id', '=', 'booked_class.select_subject_id')
              ->leftJoin('user', 'user.phone_number', '=', 'select_subject.user_phone_number')
              ->leftJoin('subject', 'subject.id', '=', 'select_subject.subject_id')
              ->leftJoin('teacher_time_availability', 'teacher_time_availability.id', '=', 'booked_class.teacher_time_availability_id')
              ->where('teacher_time_availability.date', '>', date('Y-m-d'))
              ->where('booked_class.user_phone_number', $user_phone_number)
              ->get(['user.name',
                     'subject.subject',
                     'teacher_time_availability.date',
                     'teacher_time_availability.from',
                     'teacher_time_availability.to'
                     ]);
              if($pastClass)
              return response()->json($pastClass); 

       }

       public function oneClass(Request $request, $booked_class_id){
              //getting one  class
              $oneclass = BookedClass::leftJoin('select_subject', 'select_subject.id', '=', 'booked_class.select_subject_id')
              ->leftJoin('user', 'user.phone_number', '=', 'select_subject.user_phone_number')
              ->leftJoin('subject', 'subject.id', '=', 'select_subject.subject_id')
              ->leftJoin('teacher_location_availability', 'teacher_location_availability.id', '=', 'booked_class.teacher_location_availability_id')
              ->leftJoin('teacher_time_availability', 'teacher_time_availability.id', '=', 'booked_class.teacher_time_availability_id')
              ->leftJoin('dialog', 'dialog.booked_class_id', '=', 'booked_class.id')
              ->where('booked_class.id', $booked_class_id)
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
       }
       public function pending(Request $request, $user_phone_number){
              //getting pastClass  class for student
              $pastClass = BookedClass::leftJoin('class_status', 'class_status.id', '=', 'booked_class.status_id')    
              ->leftJoin('select_subject', 'select_subject.id', '=', 'booked_class.select_subject_id') 
              ->leftJoin('subject', 'subject.id', '=', 'select_subject.subject_id') 
              ->leftJoin('teacher_location_availability', 'teacher_location_availability.id', '=', 'booked_class.teacher_location_availability_id') 
              ->where('booked_class.user_phone_number', $user_phone_number)
              ->where('class_status.id', $this->pending)
              ->get();
              if($pastClass)
              return response()->json($pastClass); 

       }
       public function approved(Request $request, $user_phone_number){
              //getting pastClass  class for student
              $pastClass = BookedClass::leftJoin('class_status', 'class_status.id', '=', 'booked_class.status_id')    
              ->leftJoin('select_subject', 'select_subject.id', '=', 'booked_class.select_subject_id') 
              ->leftJoin('subject', 'subject.id', '=', 'select_subject.subject_id') 
              ->leftJoin('teacher_location_availability', 'teacher_location_availability.id', '=', 'booked_class.teacher_location_availability_id') 
              ->where('booked_class.user_phone_number', $user_phone_number)
              ->where('class_status.id', $this->approvd)
              ->get();
              if($pastClass)
              return response()->json($pastClass); 

       }
}
