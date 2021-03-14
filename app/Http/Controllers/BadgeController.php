<?php

namespace App\Http\Controllers;

use App\Models\BookedClass;
use App\Models\Requirement;
use App\Models\Review;
use App\Models\SelectSubject;
use Illuminate\Http\Request;

class BadgeController extends Controller
{

    private $pending = 1;
    private $approvd = 2;
    private $complete = 3;

    public function badgeList(Request $request, $user_id)
    {
        $badge = SelectSubject::leftJoin('subject', 'subject.id', '=', 'select_subject.subject_id')
            ->leftJoin('grade', 'grade.id', '=', 'select_subject.grade_id')
            ->distinct()
            ->where('user_id', $user_id)
            ->get();
        if ($badge) {
            return response()->json($badge, 200);
        }

    }
    public function newRequirement(Request $request)
    {
        $requirement = new Requirement();
        $requirement->requirement = $request->requirement;
        $requirement->number = $request->number;
        $requirement->save();
        if ($requirement) {
            return response()->json($requirement, 201);
        }

    }

    public function requirementList()
    {
        $requirement = Requirement::all();
        if ($requirement) {
            return response()->json($requirement, 200);
        }

    }

    public function rwardList(Request $request, $user_id, $subject_id, $grade_id)
    {
        $completeClass = BookedClass::where('student_user_id', $user_id)
            ->where('status_id', $this->complete)
            ->where('subject_id', $subject_id)
            ->where('grade_id', $grade_id)
            ->get();

        $comment = Review::where('teacher_user_id', $user_id)->get();

        $review = Review::where('teacher_user_id', '=', $user_id)->get();

        $completeClassNumber = count($completeClass);
        $commentNumber = count($comment);
        $reviewNumber = count($review);
        return response()->json([
            'complete class number' => $completeClassNumber,
            'comments number' => $commentNumber,
            'review number' => $reviewNumber,
        ], 201);

    }
}
