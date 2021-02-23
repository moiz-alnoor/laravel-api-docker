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
Route::get('/teacher_profile',[TeacherController::class, 'profile']);
Route::get('/teacher_student/{user_phone_number}',[TeacherController::class, 'teacherStudent']);
// end teacher

//class 
Route::get('/past_class',[StudyClassController::class, 'pastClass']);
Route::get('/up_comming_class',[StudyClassController::class, 'upComingClass']);
Route::get('/oneClass/{id}',[StudyClassController::class, 'oneClass']);
//end class


//garde
Route::get('/grade',[GradeController::class, 'read']);
//end grade


//badge
Route::get('/badge',[BadgeController::class, 'read']);
Route::post('/badge',[BadgeController::class, 'create']);
//end badge