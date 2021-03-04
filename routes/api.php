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


//Route::middleware('auth:api')->get('/user', function (Request $request) {
  //  return $request->user();
//});


// user
// otp auth
Route::group([
  'middleware' => 'api',
  'prefix' => 'auth'

], function ($router) {
  Route::post('/login', [AuthController::class, 'login']);
  Route::post('/register', [AuthController::class, 'register']);
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::post('/refresh', [AuthController::class, 'refresh']);
  Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});

//Route::post('/register', [AuthController::class, 'r']);
//Route::post('/verify',   [AuthController::class, 'verify']);
// end otp auth

Route::put('/user_type', [UserController::class, 'userType']);
// end user

// subject
Route::post('/create_subject',[SubjectController::class, 'create']);
Route::get('/read_subject',[SubjectController::class, 'read']);
Route::get('/reade_subject/{id}',[SubjectController::class, 'readOne']);
Route::put('/update_subject/{id}',[SubjectController::class, 'update']);
Route::delete('/delete_subject/{id}',[SubjectController::class, 'delete']);
Route::post('/select_your_subject', [SubjectController::class, 'selectSubject']);
// end subject

// teacher
Route::post('/teacher_time_availability',[TeacherController::class, 'timeAvailability']);
Route::post('/teacher_location_availability',[TeacherController::class, 'locationAvailability']);
Route::post('/charge_per_hour',[TeacherController::class, 'charge']);
Route::get('/chose_teacher/{subject_id}/{grade_id}',[TeacherController::class, 'choseTeacher']);
Route::get('/teacher_profile/{teacher_phone_number}',[TeacherController::class, 'teacherProfile']);
Route::get('/teacher_student/{teacher_phone_number}',[TeacherController::class, 'teacherStudent']);
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
Route::post('/add_requirement',[BadgeController::class, 'addRequirement']);
Route::get('/reade_requirement',[BadgeController::class, 'readeRequirement']);
Route::get('/badge',[BadgeController::class, 'read']);
Route::post('/badge',[BadgeController::class, 'create']);
//end badge


//dialog
Route::post('/dialog',[DialogController::class, 'create']);
//end dialogs

//studdent
Route::get('/pick_date/{user_phone_number}',[StudentController::class, 'pickDate']);
Route::get('/pick_time/{date}/{teacher_phone_number}',[StudentController::class, 'pickTime']);
Route::get('/about_location/{teacher_phone_number}',[StudentController::class, 'aboutLocation']);
Route::get('/student_teacher/{student_phone_number}',[StudentController::class, 'studentTeacher']);
Route::post('/book',[StudentController::class, 'book']);
//end student