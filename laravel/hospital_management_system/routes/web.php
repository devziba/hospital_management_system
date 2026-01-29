<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'forgotPasswordView'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordView'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // Doctors Management
        Route::get('/doctors', [AdminController::class, 'doctors'])->name('doctors');
        Route::get('/doctors/create', [AdminController::class, 'create'])->name('doctors.create');
        Route::post('/doctors', [AdminController::class, 'store'])->name('doctors.store');
        Route::delete('/doctors/{id}', [AdminController::class, 'destroy'])->name('doctors.destroy');
        
        // Patients Management
        Route::get('/patients', [AdminController::class, 'patients'])->name('patients');
        Route::get('/patients/create', [AdminController::class, 'createPatient'])->name('patients.create');
        Route::post('/patients', [AdminController::class, 'storePatient'])->name('patients.store');
        Route::delete('/patients/{id}', [AdminController::class, 'destroyPatient'])->name('patients.destroy');

        Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
    });

    // Doctor Routes
    Route::middleware(['role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'index'])->name('dashboard');
        Route::get('/appointments', [DoctorController::class, 'appointments'])->name('appointments');
        Route::patch('/appointments/{id}', [DoctorController::class, 'updateStatus'])->name('appointments.update');
        Route::get('/patients', [DoctorController::class, 'patients'])->name('patients');
        Route::get('/schedule', [DoctorController::class, 'schedule'])->name('schedule');
        Route::get('/schedule/edit', [DoctorController::class, 'editSchedule'])->name('schedule.edit');
        Route::post('/schedule', [DoctorController::class, 'updateSchedule'])->name('schedule.update');
    });

    // Patient Routes
    Route::middleware(['role:patient'])->prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', [PatientController::class, 'index'])->name('dashboard');
        Route::get('/appointments', [PatientController::class, 'appointments'])->name('appointments');
        Route::get('/book-appointment', [AppointmentController::class, 'create'])->name('book_appointment');
        Route::post('/book-appointment', [AppointmentController::class, 'store'])->name('store_appointment');
        Route::get('/history', [PatientController::class, 'history'])->name('history');
    });

});
