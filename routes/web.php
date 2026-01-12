<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AppointmentController;
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

// Employee Routes (CRUD)
Route::resource('employees', EmployeeController::class)->except(['show']);

// Availability Routes
Route::get('/availabilities', [\App\Http\Controllers\AvailabilityController::class, 'index'])->name('availabilities.index');
Route::get('/availabilities/create', [\App\Http\Controllers\AvailabilityController::class, 'create'])->name('availabilities.create');
Route::post('/availabilities', [\App\Http\Controllers\AvailabilityController::class, 'store'])->name('availabilities.store');
Route::get('/availabilities/date/{date}', [\App\Http\Controllers\AvailabilityController::class, 'getByDate'])->name('availabilities.by-date');

// Account Routes
Route::resource('accounts', AccountController::class);

// Appointment Routes
Route::resource('appointments', AppointmentController::class);

// Home Route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
