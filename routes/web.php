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

// Availability Routes
Route::get('/availabilities', [\App\Http\Controllers\AvailabilityController::class, 'index'])->name('availabilities.index');
Route::get('/availabilities/create', [\App\Http\Controllers\AvailabilityController::class, 'create'])->name('availabilities.create');
Route::post('/availabilities', [\App\Http\Controllers\AvailabilityController::class, 'store'])->name('availabilities.store');
Route::get('/availabilities/date/{date}', [\App\Http\Controllers\AvailabilityController::class, 'getByDate'])->name('availabilities.by-date');

// Home Route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
