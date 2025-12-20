<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ...existing code...
Route::get('/', function () { return view('home'); });
Auth::routes();

Route::get('/availabilities', [\App\Http\Controllers\AvailabilityController::class, 'index'])->name('availabilities.index');
Route::get('/availabilities/create', [\App\Http\Controllers\AvailabilityController::class, 'create'])->name('availabilities.create');
Route::post('/availabilities', [\App\Http\Controllers\AvailabilityController::class, 'store'])->name('availabilities.store');
Route::get('/availabilities/date/{date}', [\App\Http\Controllers\AvailabilityController::class, 'getByDate'])->name('availabilities.by-date');

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin-only CRUD
Route::middleware(['auth','can:admin'])->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('appointments', AppointmentController::class);
});
