<?php

use App\Http\Controllers\admin\CityController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\doctor\authDoctorController;
use App\Http\Controllers\doctor\PostController;
use App\Http\Controllers\doctor\ReplyController;
use App\Http\Controllers\patient\authPatientController;
use App\Http\Controllers\patient\GeneralController;
use App\Http\Controllers\patient\MedicalController;
use App\Http\Controllers\patient\PersonalController;
use App\Http\Controllers\patient\QuestionController;
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

//patient controller
Route::post('patientLogin',[authPatientController::class,'login']);
Route::post('patientRegister',[authPatientController::class,'register']);
Route::post('generalStore',[GeneralController::class,'store'])->middleware('auth:patientApi');
Route::post('personamStore',[PersonalController::class,'store'])->middleware('auth:patientApi');
Route::post('medicalStore',[MedicalController::class,'store'])->middleware('auth:patientApi');
Route::post('questionStore',[QuestionController::class,'store'])->middleware('auth:patientApi');
Route::post('consultationStore',[ConsultationController::class,'store'])->middleware('auth:patientApi');
Route::post('patientLogout',[authPatientController::class,'logout'])->middleware('auth:patientApi');
Route::get('name',function () { return auth()->user()->name; })->middleware('auth:patientApi');
//doctor controller
Route::post('doctorLogin',[authDoctorController::class,'login']);
Route::post('doctorRegister',[authDoctorController::class,'register']);
Route::post('postStore',[PostController::class,'store'])->middleware('auth:doctorApi');
Route::post('replyStore',[ReplyController::class,'store'])->middleware('auth:doctorApi');
Route::post('doctorLogout',[authDoctorController::class,'logout'])->middleware('auth:doctorApi');
Route::post('consultationApprove',[ConsultationController::class,'consultationApprove'])->middleware('auth:doctorApi');
Route::post('consultationFinish',[ConsultationController::class,'consultationFinish'])->middleware('auth:doctorApi');
Route::get('name2',function () { return auth()->user()->name; })->middleware('auth:doctorApi');

//both
Route::get('citiesAndRegion',[CityController::class,'index']);

