<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudyClassController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\DialogController;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// user
// otp auth
Route::post('/register', [AuthController::class, 'create']);
Route::post('/verify',   [AuthController::class, 'verify']);
// end otp auth

Route::put('/user_type', [UserController::class, 'userType']);
// end user

// subject
Route::post('/subject',[SubjectController::class, 'create']);
Route::get('/subject',[SubjectController::class, 'read']);
Route::get('/subject/{id}',[SubjectController::class, 'readOne']);
Route::put('/subject/{id}',[SubjectController::class, 'update']);
Route::delete('/subject/{id}',[SubjectController::class, 'delete']);
Route::post('/select_subject', [SubjectController::class, 'selectSubject']);
// end subject

// teacher
Route::post('/time_availability',[TeacherController::class, 'timeAvailability']);
Route::post('/location_availability',[TeacherController::class, 'locationAvailability']);
Route::post('/charge',[TeacherController::class, 'charge']);
Route::get('/chose_teacher/{subject_id}/{grade_id}',[TeacherController::class, 'choseTeacher']);
Route::get('/teacher_profile/{user_phone_number}',[TeacherController::class, 'teacherProfile']);
// end teacher

//class 
Route::get('/pending_class/{user_phone_number}',[StudyClassController::class, 'pending']);
Route::get('/approved_class/{user_phone_number}',[StudyClassController::class, 'approved']);
Route::get('/past_class/{user_phone_number}',[StudyClassController::class, 'pastClass']);
Route::get('/class_details/{booked_class_id}',[StudyClassController::class, 'classDetails']);
Route::get('/group_student_class/{subject_id}/{teacher_phone_number}/{grade_id}',[StudyClassController::class, 'groupStudentClass']);
//end class

//garde
Route::get('/grade',[GradeController::class, 'read']);
Route::get('/chose_grade/{subject_id}',[GradeController::class, 'choseGrade']);
//end grade

//badge
Route::get('/badge',[BadgeController::class, 'read']);
Route::post('/badge',[BadgeController::class, 'create']);
//end badge


//dialog
Route::post('/dialog',[DialogController::class, 'create']);
//end dialogs

//studdent
Route::get('/pick_date/{user_phone_number}',[StudentController::class, 'pickDate']);
Route::get('/pick_time/{date}/{user_phone_number}',[StudentController::class, 'pickTime']);
Route::get('/about_location/{user_phone_number}',[StudentController::class, 'aboutLocation']);
//end student