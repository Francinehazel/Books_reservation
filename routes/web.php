<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\StudentLoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Auth\AdminLoginController;

// Welcome Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Admin Login Route
Route::get('/admin/login', function () {
    return view('auth.admin-login'); // Ensure this Blade view exists
})->name('admin.login');

// Student Login Routes
Route::get('/student/login', function () {
    return view('auth.student-login'); // Ensure this Blade view exists
})->name('student.login');
Route::post('/student/login', [StudentLoginController::class, 'login'])->name('student.login.post');

// Logout route for students
Route::post('/student/logout', [StudentLoginController::class, 'logout'])->name('student.logout');

// Student Registration Routes
Route::get('/student/register', [StudentController::class, 'showRegisterForm'])->name('student.register.form'); // Show registration form
Route::post('/student/register', [StudentController::class, 'register'])->name('student.register'); // Handle registration form submission

// Protected Routes for Students
Route::middleware('auth:student')->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard'); // Ensure this Blade view exists
    })->name('student.dashboard');

    // Library Page Route
    Route::get('/student/library', function () {
        return view('student.library'); // Create this blade view
    })->name('student.library');
});

// Password Reset Routes
Route::get('forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('reset-password/{token}', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->name('password.update');

Route::middleware('auth:student')->group(function () {
    Route::get('/student/library', [LibraryController::class, 'index'])->name('student.library');
});

Route::get('/books', [BookController::class, 'index']);

// Admin Login Routes
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Admin Dashboard Route
Route::middleware('auth:web')->get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');


