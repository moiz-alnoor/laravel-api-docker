<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// otp auth
Route::get('/home', function () {
  return view('home');
})->name('home');

Route::get('/register', function () {
  return view('auth.register');
})->name('register');

Route::get('/verify', function () {
  return view('auth.verify');
})->name('verify');

Route::get('/get', function () {
$data = DB::table('student')->first();
  return response()->json($data->id);
});

Route::post('/register', [AuthController::class, 'create']);
Route::post('/verify',   [AuthController::class, 'verify']);
// end otp auth