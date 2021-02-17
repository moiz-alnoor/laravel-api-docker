<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubjectController;
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


// otp auth
Route::post('/register', [AuthController::class, 'create']);
Route::post('/verify',   [AuthController::class, 'verify']);
// end otp auth

// subject
Route::post('/subjects',[SubjectController::class, 'create']);
Route::get('/subjects',[SubjectController::class, 'read']);
Route::get('subject/{$id}',[SubjectController::class, 'readOne']);
Route::put('/subjects/{id}',[SubjectController::class, 'update']);
Route::delete('/subjects/{id}',[SubjectController::class, 'delete']);
// end subject

Route::put('/user', function () {
    return 'User';
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


