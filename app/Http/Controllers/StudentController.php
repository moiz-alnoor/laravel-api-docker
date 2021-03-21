<?php

namespace App\Http\Controllers;

use App\Models\BookedClass;
use App\Models\Student;
use App\Models\TeacherLocationAvailability;
use App\Models\TeacherTimeAvailability;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function pickDate(Request $request, $teacher_id)
    {
        // pick suitable time to studey
        $pickDate = TeacherTimeAvailability::where('user_id', $teacher_id)
            ->get(['teacher_time_availability.date']);
        if ($pickDate) {
            return response()->json($pickDate, 200);
        }
    }
    public function pickTime(Request $request, $date, $teacher_id)
    {
        // pick suitable time to studey
        $pickTime = TeacherTimeAvailability::where('user_id', $teacher_id)->where('date', $date)->get();
        if ($pickTime) {
            return response()->json($pickTime, 200);
        }
    }
    public function aboutLocation(Request $request, $teacher_id)
    {
        // pick suitable time to studey
        $aboutLocation = TeacherLocationAvailability::where('user_id', $teacher_id)
            ->get();
        if ($aboutLocation) {
            return response()->json($aboutLocation, 200);
        }
    }

    public function studentTeacher(Request $request)
    {
        // getting all teachers of this student
           $user = auth()->user();
        $studentTeacher = BookedClass::leftJoin('users', 'users.id', '=', 'booked_class.teacher_user_id')
            ->leftJoin('dialog', 'dialog.user_id', '=', 'booked_class.teacher_user_id')
            ->where('booked_class.student_user_id', $user->id)
            ->distinct()
            ->get(['users.name', 'users.image_location', 'users.user_type', 'dialog.message', 'dialog.date']);
        if ($studentTeacher) {
            return response()->json($studentTeacher, 200);
        }
    }
    public function BookedClass(Request $request)
    {
        $user = auth()->user();
        $book = new BookedClass();
        $book->student_user_id = $user->id;
        $book->teacher_user_id = $request->teacher_user_id;
        $book->teacher_location_availability_id = $request->teacher_location_availability_id;
        $book->teacher_time_availability_id = $request->teacher_time_availability_id;
        $book->subject_id = $request->subject_id;
        $book->status_id = $request->status_id;
        $book->grade_id = $request->grade_id;
        $book->save();

        /* get user player id*/
        $user = User::find($request->teacher_user_id);
        $playerId = $user->player_id;

        /*call push method*/
        $this->notify($playerId);

        if ($book) {
            return response()->json($book, 201);
        }
    }

    public function notify($playerId)
    {
        $content = array(
            "en" => 'Tutme Notification :)',
        );

        $fields = array(
            'app_id' => "b27ac1bf-f719-4b8b-a2c8-b8e01131a2df",
            'include_player_ids' => array($playerId),
            // 'data' => array("foo" => "bar"),
            'contents' => $content,
        );

        $fields = json_encode($fields);
        //print("\nJSON sent:\n");
        //print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        // return $response;

    }

    public function studentReview(Request $request)
    {
             $user = auth()->user();
        $teacherReview = Student::with(['studentReview'])->where('users.id',  $user->id)->get();
        if ($teacherReview) {
            return response()->json($teacherReview, 200);
        }
    }
}
