<?php

namespace App\Http\Controllers;
use App\Models\BookedClass;
use Illuminate\Http\Request;

class StudyClassController extends Controller
{

       private  $pending = 1;
       private  $approvd = 2;
       private  $past = 3;

       public function pastClass(Request $request, $user_phone_number){
              //getting pastClass  class for student
              $pastClass = BookedClass::with(['dialog','status','subject','location','time','teacher','rating','charge'])
              ->where('booked_class.status_id', $this->past)
              ->where('booked_class.student_phone_number', $user_phone_number)
              ->get();
              if($pastClass)
              return response()->json($pastClass, 200); 

       }

      
       public function pending(Request $request, $user_phone_number){
              //getting pastClass  class for student
              $pastClass = BookedClass::with(['dialog','status','subject','location','time','teacher','rating','charge'])
              ->where('booked_class.student_phone_number', $user_phone_number)
              ->where('booked_class.status_id', $this->pending)
              ->get();
              if($pastClass)
              return response()->json($pastClass); 

       }
       public function approved(Request $request, $user_phone_number){
              //getting pastClass  class for student
              $pastClass = BookedClass::with(['dialog','status','subject','location','time','teacher','rating','charge']) 
              ->where('booked_class.student_phone_number', $user_phone_number)
              ->where('booked_class.status_id', $this->approvd)
              ->get();
              if($pastClass)
              return response()->json($pastClass); 

       }
       public function classDetails(Request $request, $booked_class_id){
              //getting one  class
              $classDetails = BookedClass::with(['dialog','status','subject','location','time','teacher','rating','charge'])->where('booked_class.id', $booked_class_id)->get();
              if($classDetails)
              return response()->json($classDetails, 200); 
       }
}
