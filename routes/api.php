<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudyClassController;

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
Route::post('/subjects',[SubjectController::class, 'create']);
Route::get('/subjects',[SubjectController::class, 'read']);
Route::get('/subjects/{id}',[SubjectController::class, 'readOne']);
Route::put('/subjects/{id}',[SubjectController::class, 'update']);
Route::delete('/subjects/{id}',[SubjectController::class, 'delete']);

Route::post('/teacher_subject', [SubjectController::class, 'teacherSubject']);
// end subject

// teacher
Route::post('/teachers_date_availability',[TeacherController::class, 'dateAvailability']);
Route::post('/teachers_time_availability',[TeacherController::class, 'timeAvailability']);
Route::post('/charge',[TeacherController::class, 'charge']);
Route::get('/teacher_profile',[TeacherController::class, 'profile']);
// end teacher

// class
Route::post('/class_location',[StudyClassController::class, 'location']);
Route::post('/class_time',[StudyClassController::class, 'time']);
Route::post('/create_class',[StudyClassController::class, 'create']);
Route::get('/class/{user_phone_number}',[TeacherController::class, 'teacherClassList']);
//end class

