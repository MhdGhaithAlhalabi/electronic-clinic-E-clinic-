<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CityController;
use App\Http\Controllers\admin\RegionController;
use App\Http\Controllers\admin\SpecializationController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\doctor\DoctorController;
use App\Http\Controllers\patient\authPatientController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

//admin controller
Route::group(['middleware' => 'auth:admin'], function () {
    Route::post('/logout', [adminController::class, 'destroy'])->name('logout');
    Route::get('/city', [CityController::class, 'create']);
    Route::post('/city', [CityController::class, 'store']);
    Route::get('/region', [RegionController::class, 'create']);
    Route::post('/region', [RegionController::class, 'store']);
    Route::post('/doctorApprove/{doctor}', [DoctorController::class, 'doctorApprove']);
    Route::get('/doctors', [DoctorController::class, 'index']);
    Route::get('/complaint', [ComplaintController::class, 'index']);
    Route::get('/complaint', [ComplaintController::class, 'index']);
    Route::post('/patientBlock/{patient}', [authPatientController::class, 'patientBlock']);
    Route::post('/patientUnblock/{patient}', [authPatientController::class, 'patientUnblock']);
    Route::post('/doctorBlock/{doctor}', [DoctorController::class, 'doctorBlock']);
    Route::get('/specialization', [SpecializationController::class, 'create']);
    Route::post('/specialization', [SpecializationController::class, 'store']);
    Route::get('/', function () {
        return view('dashboard');
    });
});
Route::get('/login', [adminController::class, 'create'])->name('login');
Route::post('/login', [adminController::class, 'store']);
Route::get('/fresh', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');
    return "migrate:fresh and seed";
});
