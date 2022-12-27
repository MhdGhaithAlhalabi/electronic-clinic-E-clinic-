<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CityController;
use App\Http\Controllers\admin\RegionController;
use App\Http\Controllers\admin\SpecializationController;
use App\Http\Controllers\doctor\DoctorController;
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

Route::get('/', function () {
    return view('welcome');
});
//admin controller
Route::get('/login',[adminController::class,'create'])->middleware('guest')->name('login');
Route::post('/login',[adminController::class,'store'])->middleware('guest');
Route::post('/logout', [adminController::class, 'destroy'])->middleware('auth:admin');
Route::get('/city', [CityController::class, 'create'])->middleware('auth:admin');
Route::post('/city', [CityController::class, 'store'])->middleware('auth:admin');
Route::get('/region', [RegionController::class, 'create'])->middleware('auth:admin');
Route::post('/region', [RegionController::class, 'store'])->middleware('auth:admin');
Route::post('/doctorApprove/{doctor}', [DoctorController::class, 'doctorApprove'])->middleware('auth:admin');
Route::get('/doctors', [DoctorController::class, 'index'])->middleware('auth:admin');
Route::get('/specialization', [SpecializationController::class, 'create'])->middleware('auth:admin');
Route::post('/specialization', [SpecializationController::class, 'store'])->middleware('auth:admin');
Route::get('/dashboard', function (){
    return view('dashboard');
})->middleware('auth:admin');
