<?php

namespace App\Http\Controllers;

use App\Models\BookedClass;
use Illuminate\Http\Request;

class StudyClassController extends Controller
{

    private $pending = 1;
    private $approvd = 2;
    private $complete = 3;

    public function complete(Request $request)
    {
        //getting pastClass  class for student
                 $user = auth()->user();
        $pastClass = BookedClass::with(['status', 'subject', 'location', 'time', 'teacher', 'charge'])
            ->where('booked_class.status_id', $this->complete)
            ->where('booked_class.student_user_id', $user->id)
            ->get();
        if ($pastClass) {
            return response()->json($pastClass, 200);
        }

    }

    public function pending(Request $request)
    {
        //getting pastClass  class for student
           $user = auth()->user();

        $pendingClass = BookedClass::with(['status', 'subject', 'location', 'time', 'teacher', 'charge'])
            ->where('booked_class.student_user_id', $user->id)
            ->where('booked_class.status_id', $this->pending)
            ->get();
        if ($pendingClass) {
            return response()->json($pendingClass, 200);
        }

    }
    public function approved(Request $request)
    {
        //getting pastClass  class for student
                 $user = auth()->user();
        $approvedClass = BookedClass::with(['status', 'subject', 'location', 'time', 'teacher', 'charge'])
            ->where('booked_class.student_user_id', $user->id)
            ->where('booked_class.status_id', $this->approvd)
            ->get();
        if ($approvedClass) {
            return response()->json($approvedClass, 200);
        }

    }
    public function class(Request $request, $subject_id,$grade_id)
    {
        //getting one  class with details
               $user = auth()->user();
        $pendingClass = BookedClass::leftJoin('teacher_location_availability', 'teacher_location_availability.id','=',
            'booked_class.teacher_location_availability_id')
        ->leftJoin('subject', 'subject.id','=','booked_class.subject_id')
          ->leftJoin('teacher_time_availability', 'teacher_time_availability.id','=','booked_class.teacher_location_availability_id')
            ->where('booked_class.teacher_user_id', $user->id)
                        ->where('booked_class.subject_id', $subject_id)
                                    ->where('booked_class.grade_id', $grade_id)
                                    ->distinct()
            ->get(['longitude','latitude','subject','from','to','date']);
        if ($pendingClass) {
            return response()->json($pendingClass, 200);
        }

    }

    public function classGroup(Request $request, $subject_id, $grade_id)
    {     $user = auth()->user();

        $classGroup = BookedClass::leftJoin('users', 'users.id', '=', 'booked_class.student_user_id')
            ->leftJoin('dialog', 'dialog.user_id', '=', 'booked_class.student_user_id')
            ->where('booked_class.subject_id', $subject_id)
            ->where('booked_class.teacher_user_id', $user->id)
            ->where('booked_class.grade_id', $grade_id)
            ->distinct()
            ->get(['users.name', 'users.image_location', 'dialog.message', 'dialog.date']);
        if ($classGroup) {
            return response()->json($classGroup, 200);
        }

    }
 

}
