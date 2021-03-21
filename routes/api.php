<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\DialogController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudyClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;


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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
});
 */

/* user auth */
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
/* end user auth */

/* user */
// set user type
Route::middleware('auth:api')->put('/user/type/{user_type_id}', [UserController::class, 'userType']);
//set player id
Route::middleware('auth:api')->put('/user/{player_id}', [UserController::class, 'setPlayerId']);
//edit user
Route::put('/user/edit/{user_type_id}', [UserController::class, 'userEdit']);
// get user
Route::get('/user/{user_type_id}', [UserController::class, 'read']);
/* end user*/

/* subject */
Route::middleware('auth:api')->post('/subject', [SubjectController::class, 'create']);
Route::middleware('auth:api')->get('/subject', [SubjectController::class, 'read']);
Route::middleware('auth:api')->get('/subject/{id}', [SubjectController::class, 'readOne']);
Route::middleware('auth:api')->put('/subject/{id}', [SubjectController::class, 'update']);
Route::middleware('auth:api')->delete('/subject/{id}', [SubjectController::class, 'delete']);
Route::middleware('auth:api')->post('/select_your_subject', [SubjectController::class, 'selectSubject']);
/* end subject */

/* teacher */
Route::middleware('auth:api')->post('/teacher/time_availability', [TeacherController::class, 'timeAvailability']);
Route::middleware('auth:api')->post('/teacher/location_availability', [TeacherController::class, 'locationAvailability']);
Route::middleware('auth:api')->post('/teacher/charge', [TeacherController::class, 'charge']);
Route::middleware('auth:api')->get('/chose_teacher/{subject_id}/{grade_id}', [TeacherController::class, 'choseTeacher']);
Route::middleware('auth:api')->get('/teacher', [TeacherController::class, 'teacher']);
Route::middleware('auth:api')->get('/teacher/student', [TeacherController::class, 'teacherStudent']);
Route::get('/teacher/review', [TeacherController::class, 'teacherReview']);
Route::get('/teacher/notification/{user_id}', [TeacherController::class, 'teacherNotification']);
Route::middleware('auth:api')->get('teacher/student/same_class/{subject_id}/{grade_id}', [StudyClassController::class, 'classGroup']);
/* end teacher */

/* class */
Route::middleware('auth:api')->get('/class/pending',  [StudyClassController::class, 'pending']);
Route::middleware('auth:api')->get('/class/approved', [StudyClassController::class, 'approved']);
Route::middleware('auth:api')->get('/class/complete', [StudyClassController::class, 'complete']);
// class date, location, time
Route::middleware('auth:api')->get('/class/{subject_id}/{grade_id}', [StudyClassController::class, 'class']);
/* end class */

/* grade */
Route::middleware('auth:api')->get('/grade', [GradeController::class, 'list']);
Route::middleware('auth:api')->get('/chose_grade/{subject_id}', [GradeController::class, 'choseGrade']);
/* end grade */

/* dialog */
Route::middleware('auth:api')->post('/dialog', [DialogController::class, 'create']);
Route::middleware('auth:api')->get('class/dialog/{teacher_id}/{subject_id}/{grade_id}', [DialogController::class, 'classDialog']);
/* end dialog */

/* student */
Route::middleware('auth:api')->get('/pick_date/{teacher_id}', [StudentController::class, 'pickDate']);
Route::middleware('auth:api')->get('/pick_time/{date}/{teacher_id}', [StudentController::class, 'pickTime']);
Route::middleware('auth:api')->get('/about_location/{teacher_id}', [StudentController::class, 'aboutLocation']);
Route::middleware('auth:api')->get('/student/teacher', [StudentController::class, 'studentTeacher']);
Route::middleware('auth:api')->get('/student/review', [StudentController::class, 'studentReview']);
Route::middleware('auth:api')->post('/student/booked_class', [StudentController::class, 'BookedClass']);
Route::get('/student/booked_class_list', [StudentController::class, 'list']);
/* end student */

/* badge */
Route::middleware('auth:api')->post('/requirement', [BadgeController::class, 'newRequirement']);
Route::middleware('auth:api')->get('/requirement', [BadgeController::class, 'requirementList']);
Route::middleware('auth:api')->get('/badge', [BadgeController::class, 'badgeList']);
Route::middleware('auth:api')->get('/reward/{subject_id}/{grade_id}', [BadgeController::class, 'rwardList']);
/* end badge */

Route::middleware('auth:api')->get('/assa', function () {
   $user = auth()->user();
    return $user->id;
});
