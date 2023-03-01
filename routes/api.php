<?php

use App\Http\Controllers\admin\CityController;
use App\Http\Controllers\admin\SpecializationController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\doctor\authDoctorController;
use App\Http\Controllers\doctor\DoctorController;
use App\Http\Controllers\doctor\PostController;
use App\Http\Controllers\doctor\ReplyController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\patient\authPatientController;
use App\Http\Controllers\patient\QuestionController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|//    Route::post('personalStore', [PersonalController::class, 'store']);//after register  personal and medical
//    Route::post('medicalStore', [MedicalController::class, 'store']);//after register  personal and medical
*/

//patient controller
Route::post('patientLogin', [authPatientController::class, 'login']);
Route::post('patientRegister', [authPatientController::class, 'register']);
Route::group(['middleware' => 'auth:patientApi'], function () {
    Route::post('register2', [authPatientController::class, 'register2']);//after register  personal and medical
    Route::post('patientLogout', [authPatientController::class, 'logout']);
    Route::get('home', [authPatientController::class, 'home']);//home page
    Route::get('allDoctors', [authDoctorController::class, 'allDoctors']);//get all doctors
    Route::get('postsView', [PostController::class, 'index']);//get posts
    Route::post('questionStore', [QuestionController::class, 'store']);//add question
    Route::get('questionView', [QuestionController::class, 'index']);//add question
    Route::post('consultationStore', [ConsultationController::class, 'store']);//get waiting Consultation
    Route::get('waitingConsultation', [ConsultationController::class, 'waitingConsultation']);//add consultation
    //Route::get('UnderProcessingConsultation', [ConsultationController::class, 'UnderProcessingConsultation']);//get Under Processing Consultation
    Route::get('finishConsultation', [ConsultationController::class, 'finishConsultation']);//get finishConsultation
    Route::get('roomView', [RoomController::class, 'index']);
    Route::post('messagesView', [MessageController::class, 'index']);
    Route::post('specializationDoctor', [DoctorController::class, 'specializationDoctor']);
    Route::get('medication', [MedicationController::class, 'index']);//get medication
    Route::post('doctorView', [authDoctorController::class, 'doctorView']);//get medication
    Route::post('messageStore', [MessageController::class, 'store']);//add message
    Route::post('rateStore', [RateController::class, 'store']);//add message
    Route::post('complaintStore', [ComplaintController::class, 'store']);//add complaint
    Route::post('doctorByS', [authDoctorController::class, 'doctorByS']);//doctorByS
});
//doctor controller
Route::post('doctorLogin', [authDoctorController::class, 'login']);
Route::post('doctorRegister', [authDoctorController::class, 'register']);
Route::group(['middleware' => 'auth:doctorApi'], function () {
    //Route::get('cities2',[CityController::class,'index']);
    Route::post('doctorLogout', [authDoctorController::class, 'logout']);
    // Route::get('specializationView2', [SpecializationController::class, 'index']);
    Route::get('allDoctors2', [authDoctorController::class, 'allDoctors']);//get all doctors
    Route::get('postsView2', [PostController::class, 'index']);//get posts
    Route::post('postStore', [PostController::class, 'store']);//add post
    Route::get('unansweredQuestion', [QuestionController::class, 'index2']);//get unanswered Question
    Route::get('questionView2', [QuestionController::class, 'index']);//get unanswered Question
    Route::post('replyStore', [ReplyController::class, 'store']);//reply comment
    Route::post('consultationUnderProcessing', [ConsultationController::class, 'consultationUnderProcessing']);//make consultation Under Processing
    Route::post('consultationFinish', [ConsultationController::class, 'consultationFinish']);//make consultationFinish
    Route::get('PublicConsultationView', [ConsultationController::class, 'index']);//get Public Consultation
    Route::get('PrivateConsultationView', [ConsultationController::class, 'index2']);//get Private Consultation
    Route::post('consultationView', [ConsultationController::class, 'consultationView']);//get Private Consultation
    Route::post('medicationStore', [MedicationController::class, 'store']);//add medication
    Route::post('messagesView2', [MessageController::class, 'index']);
    Route::get('roomView2', [RoomController::class, 'index2']);
    Route::post('doctorView2', [authDoctorController::class, 'doctorView']);//get medication
    Route::post('messageStore2', [MessageController::class, 'store2']);//add message
});
//both
Route::get('cities', [CityController::class, 'index']);
Route::get('specializationView', [SpecializationController::class, 'index']);


