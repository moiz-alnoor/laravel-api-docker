<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\DialogController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudyClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Client\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use App\Models\User;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//});


// otp auth
Route::group([
    'middleware' => 'api',
    //'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/sign_in', [AuthController::class, 'signIn']);
    Route::post('/verify', [AuthController::class, 'verify']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout/{user_id}', [AuthController::class, 'logout']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

// end otp auth


// user
Route::middleware('auth:api')->put('/user_type/{user_id}', [UserController::class, 'userType']);
// end user

// subject
Route::middleware('auth:api')->post('/subject', [SubjectController::class, 'create']);
Route::middleware('auth:api')->get('/subject', [SubjectController::class, 'read']);
Route::middleware('auth:api')->get('/subject/{id}', [SubjectController::class, 'readOne']);
Route::middleware('auth:api')->put('/subject/{id}', [SubjectController::class, 'update']);
Route::middleware('auth:api')->delete('/subject/{id}', [SubjectController::class, 'delete']);
Route::middleware('auth:api')->post('/select_your_subject', [SubjectController::class, 'selectSubject']);
// end subject

// teacher
Route::middleware('auth:api')->post('/teacher_time_availability', [TeacherController::class, 'timeAvailability']);
Route::middleware('auth:api')->post('/teacher_location_availability', [TeacherController::class, 'locationAvailability']);
Route::middleware('auth:api')->post('/charge_per_hour', [TeacherController::class, 'charge']);
Route::middleware('auth:api')->get('/chose_teacher/{subject_id}/{grade_id}', [TeacherController::class, 'choseTeacher']);
Route::middleware('auth:api')->get('/teacher/{user_id}', [TeacherController::class, 'teacher']);
Route::middleware('auth:api')->get('/teacher/student/{user_id}', [TeacherController::class, 'teacherStudent']);
Route::middleware('auth:api')->get('/teacher/review/{user_id}', [TeacherController::class, 'teacherReview']);
Route::middleware('auth:api')->get('/teacher/notification/{user_id}', [TeacherController::class, 'teacherNotification']);
// end teacher

//class
Route::middleware('auth:api')->get('/class/pending/{user_id}', [StudyClassController::class, 'pending']);
Route::middleware('auth:api')->get('/class/approved/{user_id}', [StudyClassController::class, 'approved']);
Route::middleware('auth:api')->get('/class/complete/{user_id}', [StudyClassController::class, 'complete']);
Route::middleware('auth:api')->get('/class/{booked_class_id}', [StudyClassController::class, 'bookedClass']);
//Route::middleware('auth:api')->get('/group_student_class/{subject_id}/{teacher_phone_number}/{grade_id}', [StudyClassController::class, 'groupStudentClass']);
//end class

//garde
Route::middleware('auth:api')->get('/grade', [GradeController::class, 'read']);
Route::middleware('auth:api')->get('/chose_grade/{subject_id}', [GradeController::class, 'choseGrade']);
//end grade

//dialog
Route::middleware('auth:api')->post('/dialog', [DialogController::class, 'create']);
Route::middleware('auth:api')->get('/dialog/{teacher_user_id}/{subject_id}/{grade_id}', [DialogController::class, 'dialog']);
//end dialogs

//studdent
Route::middleware('auth:api')->get('/pick_date/{user_id}', [StudentController::class, 'pickDate']);
Route::middleware('auth:api')->get('/pick_time/{date}/{user_id}', [StudentController::class, 'pickTime']);
Route::middleware('auth:api')->get('/about_location/{user_id}', [StudentController::class, 'aboutLocation']);
Route::middleware('auth:api')->get('/student/teacher/{user_id}', [StudentController::class, 'studentTeacher']);
Route::middleware('auth:api')->post('/student/booked_class', [StudentController::class, 'BookedClass']);
//end student

//badge
Route::middleware('auth:api')->post('/requirement', [BadgeController::class, 'addRequirement']);
Route::middleware('auth:api')->get('/requirement', [BadgeController::class, 'requirementList']);
Route::middleware('auth:api')->get('/badge/{user_id}', [BadgeController::class, 'read']);
Route::middleware('auth:api')->get('/reward/{user_id}/{subject_id}/{grade_id}', [BadgeController::class, 'rwardList']);
//end badge

Route::get('/users', function () {

  });