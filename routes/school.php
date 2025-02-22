<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\School\ProfileController;
use App\Http\Controllers\School\Auth\VerifyEmailController;
use App\Http\Controllers\School\Auth\RegisteredSchoolController;
use App\Http\Controllers\School\Auth\AuthenticatedSessionController;

Route::prefix('School')->name('School.')->group(function () {

    // Guest Routes
    Route::middleware('guest:school')->group(function () {
        Route::get('register', [RegisteredSchoolController::class, 'create'])
            ->name('register');

        Route::post('register', [RegisteredSchoolController::class, 'store']);

        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

        Route::post('login', [AuthenticatedSessionController::class, 'store']);
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
    });
});
