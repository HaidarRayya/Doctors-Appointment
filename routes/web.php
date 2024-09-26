<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;

use App\Http\Controllers\MailController;

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


Route::get('/',[UserController::class,'index']);
Route::get('/login',[UserController::class,'showlogin'])->name('login');
Route::post('/login',[UserController::class,'login']);
Route::get('/logout',[UserController::class,'logout']);


Route::get('/signup',[UserController::class,'showsignup']);
Route::post('/signup/doctorSignup',[UserController::class,'doctorSignup']);
Route::post('/signup/patientSignup',[UserController::class,'patientSignup']);
Route::post('/signup/sellerSignup',[UserController::class,'sellerSignup']);

Route::get('/updateAccountDoctor/{id}',[UserController::class,'updateAccountDoctor'])->middleware('auth');
Route::get('/updateAccountPatient/{id}',[UserController::class,'updateAccountPatient'])->middleware('auth');
Route::get('/updateAccountSeller/{id}',[UserController::class,'updateAccountSeller'])->middleware('auth');

Route::get('/contactUs',[UserController::class,'contactUs'])->middleware('auth');
Route::get('/MainDoctor',[UserController::class,'MainDoctor']);
Route::get('/showDoctorDetail/{id}',[UserController::class,'showDoctorDetail']);

Route::post('/updateDoctorDetail/{id}',[UserController::class,'updateDoctorDetail']);

Route::get('/calender/{id}',[UserController::class,'calender'])->middleware('auth');

Route::get('/dailyDatesPatientToDoctor/{id}/{year}/{month}/{day}',[UserController::class,'dailyDatesForPatient']);
Route::get('/dailyDatesDoctor/{id}/{year}/{month}/{day}',[UserController::class,'dailyDatesFordoctor']);


Route::get('/nextCalender/{id}/{year}/{month}',[UserController::class,'nextCalender']);
Route::get('/previousCalender/{id}/{year}/{month}',[UserController::class,'previousCalender']);

Route::get('/update',[UserController::class,'test'])->middleware('auth');
Route::get('/mm',[UserController::class,'test'])->middleware('auth');

Route::post('/updateAccountDoctor/{id}',[UserController::class,'updateDoctor']);
Route::post('/updateAccountPatient/{id}',[UserController::class,'updatePatient']);
Route::post('/updateAccountSeller/{id}',[UserController::class,'updateSeller']);

Route::post('/contactWithManager',[UserController::class,'contactWithManager']);
Route::post('/contactWithDevelopers',[UserController::class,'contactWithDevelopers']);

Route::post('/addAppointment',[AppointmentController::class,'addAppointment']);
Route::post('/doctorDddAppointment',[AppointmentController::class,'doctorDddAppointment']);

Route::post('/deleteAppointment/{id}',[AppointmentController::class,'deleteAppointment']);

Route::get('/dailyDatesPatient/{id}',[AppointmentController::class,'showDailyDatesPatient'])->middleware('auth');
Route::post('/unavailableAppointment',[AppointmentController::class,'unavailableAppointment']);



Route::get('/seller',[UserController::class,'showSeller']);
Route::get('/admin',[UserController::class,'showAdminPage']);
Route::get('/transactionPage',[UserController::class,'showTransactionPage']);

Route::post('/sellerTransformation',[UserController::class,'sellerTransformation']);
Route::post('/adminTransformation',[UserController::class,'adminTransformation']);