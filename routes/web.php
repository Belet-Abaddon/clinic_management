<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
// Note: You should create these controllers to replace the static "John Doe" logic
// use App\Http\Controllers\DoctorController;
// use App\Http\Controllers\AppointmentController;

// Admin Controllers
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome', ['isLoggedIn' => false]);
});

/*
|--------------------------------------------------------------------------
| Patient / User Routes (Authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::post('/doctors/book', [DoctorController::class, 'store'])->name('doctors.book');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::delete('/my-appointments/{id}', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::post('/{user}/promote', [AdminUserController::class, 'promote'])->name('promote');
        Route::post('/{user}/demote', [AdminUserController::class, 'demote'])->name('demote');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
    });

    // Doctors Management
    Route::prefix('doctors')->name('doctors.')->group(function () {
        Route::get('/', [AdminDoctorController::class, 'index'])->name('index');
        Route::post('/', [AdminDoctorController::class, 'store'])->name('store');
        Route::put('/{doctor}', [AdminDoctorController::class, 'update'])->name('update');
        Route::delete('/{doctor}', [AdminDoctorController::class, 'destroy'])->name('destroy');
    });

    // Schedules Management
    Route::prefix('schedules')->name('schedules.')->group(function () {
        Route::get('/', [AdminScheduleController::class, 'index'])->name('index');
        Route::post('/', [AdminScheduleController::class, 'store'])->name('store');
        Route::post('/multiple', [AdminScheduleController::class, 'storeMultiple'])->name('store.multiple');
        Route::put('/{schedule}', [AdminScheduleController::class, 'update'])->name('update');
        Route::delete('/{schedule}', [AdminScheduleController::class, 'destroy'])->name('destroy');
        Route::get('/doctor/{doctorId}', [AdminScheduleController::class, 'getByDoctor'])->name('by-doctor');
    });

    // Appointments Management
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', [AdminAppointmentController::class, 'index'])->name('index');
        Route::get('/get-schedules', [AdminAppointmentController::class, 'getSchedules'])->name('getSchedules');
        Route::post('/', [AdminAppointmentController::class, 'store'])->name('store');
        Route::patch('/{id}/status', [AdminAppointmentController::class, 'updateStatus'])->name('updateStatus');
    });
    Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
