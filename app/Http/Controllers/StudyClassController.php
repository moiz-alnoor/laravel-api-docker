<?php

namespace App\Http\Controllers;

use App\Models\BookedClass;
use Illuminate\Http\Request;

class StudyClassController extends Controller
{

    private $pending = 1;
    private $approvd = 2;
    private $complete = 3;

    public function complete(Request $request, $user_id)
    {
        //getting pastClass  class for student
        $pastClass = BookedClass::with(['status', 'subject', 'location', 'time', 'teacher', 'charge'])
            ->where('booked_class.status_id', $this->complete)
            ->where('booked_class.student_user_id', $user_id)
            ->get();
        if ($pastClass) {
            return response()->json($pastClass, 200);
        }

    }

    public function pending(Request $request, $user_id)
    {
        //getting pastClass  class for student
        $pendingClass = BookedClass::with(['status', 'subject', 'location', 'time', 'teacher', 'charge'])
            ->where('booked_class.student_user_id', $user_id)
            ->where('booked_class.status_id', $this->pending)
            ->get();
        if ($pendingClass) {
            return response()->json($pendingClass, 200);
        }

    }
    public function approved(Request $request, $user_id)
    {
        //getting pastClass  class for student
        $approvedClass = BookedClass::with(['status', 'subject', 'location', 'time', 'teacher', 'charge'])
            ->where('booked_class.student_user_id', $user_id)
            ->where('booked_class.status_id', $this->approvd)
            ->get();
        if ($approvedClass) {
            return response()->json($approvedClass, 200);
        }

    }
    public function bookedClass(Request $request, $booked_class_id)
    {
        //getting one  class with details
        $pendingClass = BookedClass::with(['status', 'subject', 'location', 'time', 'teacher'])
            ->where('booked_class.id', $booked_class_id)
            ->get();
        if ($pendingClass) {
            return response()->json($pendingClass, 200);
        }

    }

    public function classGroup(Request $request, $user_id, $subject_id, $grade_id)
    {

        $classGroup = BookedClass::leftJoin('users', 'users.id', '=', 'booked_class.student_user_id')
            ->leftJoin('dialog', 'dialog.user_id', '=', 'booked_class.student_user_id')
            ->where('booked_class.subject_id', $subject_id)
            ->where('booked_class.teacher_user_id', $user_id)
            ->where('booked_class.grade_id', $grade_id)
            ->distinct()
            ->get(['users.name', 'users.image_location', 'dialog.message', 'dialog.date']);
        if ($classGroup) {
            return response()->json($classGroup, 200);
        }

    }
 

}
