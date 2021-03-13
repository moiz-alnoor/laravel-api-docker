<?php

namespace App\Http\Controllers;

use App\Models\Dialog;
use Illuminate\Http\Request;

class DialogController extends Controller
{
    public function create(Request $request)
    {
        $dialog = new Dialog();
        $dialog->subject_id = $request->subject_id;
        $dialog->grade_id = $request->grade_id;
        $dialog->teacher_user_id = $request->teacher_user_id;
        $dialog->message = $request->message;
        $dialog->date = date("M j");
        $dialog->save();
        if ($dialog) {
            return response()->json($dialog, 201);
        }

    }
    public function dialog(Request $request, $teacher_user_id, $subject_id, $grade_id)
    {

        $pendingClass = Dialog::join('users', 'users.id', '=', 'dialog.teacher_user_id')
            ->where('dialog.subject_id', $subject_id)
            ->where('dialog.grade_id', $grade_id)
            ->where('dialog.teacher_user_id', $teacher_user_id)
            ->get(['users.user_type', 'users.image_location', 'dialog.message']);
        if ($pendingClass) {
            return response()->json($pendingClass, 200);
        }

    }
}
