<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Charge;
use App\Models\TeacherTimeAvailability;
use App\Models\TeacherLocationAvailability;
use App\Models\BookedClass;
use App\Models\SelectSubject;
use App\Models\User;


class TeacherController extends Controller
{
    public function timeAvailability(Request $request){
        //set time available
        $teacher = new TeacherTimeAvailability();
        $teacher->from = $request->from;
        $teacher->to = $request->to;
        $teacher->date = $request->date;
        $teacher->user_phone_number = '+'.$request->user_phone_number;
        $teacher->save();
        if($teacher)
        return response()->json($teacher, 201);
    }
    

    public function locationAvailability(Request $request){
        //set date available
        $loaction = new TeacherLocationAvailability();
        $loaction->user_phone_number = '+'.$request->user_phone_number;
        $loaction->longitude = $request->longitude;
        $loaction->latitude = $request->latitude;
        $loaction->save();
        if($loaction)
        return response()->json($loaction, 201);
    }

    public function charge(Request $request){
        //teacher charge per hour
        $teacher = new Charge();
        $teacher->user_phone_number = '+'.$request->user_phone_number;
        $teacher->amount = $request->amount;
        $teacher->save();
        if($teacher)
        return response()->json($teacher, 201); 
    }

    public function manyTeacher(Request $request, $id){ 
        // getting teacher based chosen subject and grade 
        $manyTeacher = SelectSubject::join('rating', 'rating.user_phone_number', '=', 'select_subject.user_phone_number')
        ->join('charging_hours', 'charging_hours.user_phone_number', '=', 'select_subject.user_phone_number')
        ->join('user', 'user.phone_number', '=', 'select_subject.user_phone_number')
        ->join('subject', 'subject.id', '=', 'select_subject.subject_id')
        ->where('select_subject.id',$id)
        ->get(['user.name',
               'charging_hours.amount', 
               'rating.rating',
               'subject.subject',
               'user.image_location']);
        if($manyTeacher)
        
 //       $rating = Rating::where('user_phone_number','+'.$request->user_phone_number)->get();
   //     $charge = Charge::where('user_phone_number','+'.$request->user_phone_number)->get();

     //   if(count($rating) > 0  and count($charge) > 0){
    
  
        return response()->json($manyTeacher); 

}

    public function teacherStudent(Request $request, $user_phone_number){
        //getting teacher student who teach
        $class = BookedClass::join('user', 'user.phone_number', '=', 'booked_class.user_phone_number')
        ->join('select_subject', 'select_subject.id', '=', 'booked_class.select_subject_id')
        ->where('select_subject.user_phone_number' , $user_phone_number)
        ->get(['user.*']);
        if($class)
        return response()->json($class); 
    }
    
  
}

