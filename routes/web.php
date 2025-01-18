<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\StudentLoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\BookController;

// Welcome Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Admin Login Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:web')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); // Ensure this blade view exists
        })->name('admin.dashboard');
    });
});

// Student Login and Registration Routes
Route::prefix('student')->group(function () {
    // Student Login Routes
    Route::get('/login', function () {
        return view('auth.student-login'); // Ensure this blade view exists
    })->name('student.login');
    Route::post('/login', [StudentLoginController::class, 'login'])
        ->name('student.login.post')
        ->middleware('throttle:3,1'); // Limit to 3 attempts per minute
    Route::post('/logout', [StudentLoginController::class, 'logout'])->name('student.logout');

    // Registration Routes
    Route::get('/register', [StudentController::class, 'showRegisterForm'])->name('student.register.form');
    Route::post('/register', [StudentController::class, 'register'])->name('student.register');

    // Protected Routes for Students
    Route::middleware('auth:student')->group(function () {
        Route::get('/dashboard', function () {
            return view('student.dashboard'); // Ensure this blade view exists
        })->name('student.dashboard');

        Route::get('/library', [LibraryController::class, 'index'])->name('student.library');
        Route::get('/user-management', [StudentController::class, 'userManagement'])->name('student.user-management');
    });

    // Forgot Password Routes
    Route::get('/password/request', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('student.password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('student.password.email');

    // Reset Password Routes
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('student.password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('student.password.update');
});

// General Password Reset Routes
Route::prefix('password')->group(function () {
    Route::get('/forgot', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset', [PasswordResetController::class, 'reset'])->name('password.update');
});

// Book Routes
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Student User Management
Route::middleware('auth:student')->group(function () {
    Route::get('/student/user-management', [StudentController::class, 'userManagement'])->name('student.user-management');
    Route::put('/student/update-profile', [StudentController::class, 'updateProfile'])->name('student.update.profile');
    Route::post('/student/update-password', [StudentController::class, 'updatePassword'])->name('student.update.password');
});

Route::get('/student/info', [StudentController::class, 'showStudentInfo'])->name('student.info');

Route::middleware('auth:student')->group(function () {
    Route::delete('/student/delete-account', [StudentController::class, 'deleteAccount'])->name('student.delete.account');
});

Route::middleware('auth:web')->prefix('admin')->group(function () {
    Route::get('/user-management', [AdminController::class, 'userManagement'])->name('admin.user-management');
    Route::put('/update-profile', [AdminController::class, 'updateProfile'])->name('admin.update.profile');
    Route::put('/update-password', [AdminController::class, 'updatePassword'])->name('admin.update.password');
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});
