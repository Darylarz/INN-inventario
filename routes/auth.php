<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    // ❌ Vistas Blade (ya NO usas estas)
    // Route::get('register', [RegisteredUserController::class, 'create'])
    //    ->name('register');

    // ✔ Registro API
    Route::post('register', [RegisteredUserController::class, 'store']);

    // ❌ Vista Blade login
    // Route::get('login', [AuthenticatedSessionController::class, 'create'])
    //    ->name('login');

    // ✔ Login API
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // ❌ Vista Blade forgot-password
    // Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    //     ->name('password.request');

    // ✔ Forgot password API
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // ❌ Vista reset password
    // Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    //     ->name('password.reset');

    // ✔ Reset password API
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {

    // ❌ Vista Blade verify-email
    // Route::get('verify-email', EmailVerificationPromptController::class)
    //     ->name('verification.notice');

    // ✔ Verificación API (esto puede quedar)
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // ❌ Vista confirm-password
    // Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
    //     ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // ✔ Cambiar contraseña API
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // ✔ Logout API
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
