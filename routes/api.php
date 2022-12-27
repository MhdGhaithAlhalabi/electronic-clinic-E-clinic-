<?php

use App\Http\Controllers\doctor\authDoctorController;
use App\Http\Controllers\patient\authPatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//user controller
Route::post('patientLogin',[authPatientController::class,'login']);
Route::post('patientRegister',[authPatientController::class,'register']);
Route::post('patientLogout',[authPatientController::class,'logout'])->middleware('auth:patientApi');
//doctor controller
Route::post('doctorLogin',[authDoctorController::class,'login']);
Route::post('doctorRegister',[authDoctorController::class,'register']);
Route::post('doctorLogout',[authDoctorController::class,'logout'])->middleware('auth:doctorApi');

