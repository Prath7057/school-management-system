<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\School\ProfileController;
use App\Http\Controllers\School\Auth\PasswordController;
use App\Http\Controllers\School\Auth\NewPasswordController;
use App\Http\Controllers\School\Auth\VerifyEmailController;
use App\Http\Controllers\School\Auth\RegisteredSchoolController;
use App\Http\Controllers\School\Auth\PasswordResetLinkController;
use App\Http\Controllers\School\Auth\ConfirmablePasswordController;
use App\Http\Controllers\School\Auth\AuthenticatedSessionController;
use App\Http\Controllers\School\StudentController;

Route::prefix('School')->name('School.')->group(function () {

    Route::get('/', function () {
        return view('School.auth.login');
    });
    // Guest Routes
    Route::middleware('guest:school')->group(function () {
        Route::get('register', [RegisteredSchoolController::class, 'create'])
            ->name('register');

        Route::post('register', [RegisteredSchoolController::class, 'store']);

        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('password.request');

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');

        Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('password.store');
        //



    });

    // Authenticated Routes
    Route::middleware('auth:school')->group(function () {
        Route::get('/dashboard', function () {
            return view('School.dashboard');
        })->name('dashboard');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Email Verification
        Route::get('verify-email', [VerifyEmailController::class, 'show'])
            ->name('verification.notice');

        Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, 'verify'])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('email/verification-notification', [VerifyEmailController::class, 'resend'])
            ->middleware('throttle:6,1')
            ->name('verification.send');

        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');

        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        //from here start code to implement under school task
        Route::get('add-student', [StudentController::class, 'create'])->name('addStudent');
        Route::post('store-student', [StudentController::class, 'store'])->name('storeStudent');
        Route::get('students', [StudentController::class, 'index'])->name('listStudents');
        Route::get('edit-student/{id}', [StudentController::class, 'edit'])->name('editStudent');
        Route::put('update-student/{id}', [StudentController::class, 'update'])->name('updateStudent');
        Route::delete('delete-student/{id}', [StudentController::class, 'destroy'])->name('deleteStudent');
        Route::get('import-students', [StudentController::class, 'createImportStudents'])->name('importStudents');
        Route::post('import-students', [StudentController::class, 'importStudents'])->name('importStudents');
    });
});
