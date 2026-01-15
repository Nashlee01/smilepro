<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
});

// Authentication Routes
Auth::routes();

// Employee Routes
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

// Patient Routes
// Routes for patient management functionality
Route::get('/patients', [\App\Http\Controllers\PatientController::class, 'index'])->name('patients.index');        // Display list of patients
Route::get('/patients/create', [\App\Http\Controllers\PatientController::class, 'create'])->name('patients.create'); // Show form to create new patient
Route::post('/patients', [\App\Http\Controllers\PatientController::class, 'store'])->name('patients.store');       // Store new patient in database

// Availability Routes
Route::get('/availabilities', [\App\Http\Controllers\AvailabilityController::class, 'index'])->name('availabilities.index');
Route::get('/availabilities/create', [\App\Http\Controllers\AvailabilityController::class, 'create'])->name('availabilities.create');
Route::post('/availabilities', [\App\Http\Controllers\AvailabilityController::class, 'store'])->name('availabilities.store');
Route::get('/availabilities/date/{date}', [\App\Http\Controllers\AvailabilityController::class, 'getByDate'])->name('availabilities.by-date');

// Home Route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
