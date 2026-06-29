<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['guest']
], function () {
    // LOGIN
    Route::get('Padminlogin', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('Padminlogin', [AuthenticatedSessionController::class, 'store']);
});

Route::group([
    'middleware' => ['auth', 'auth.activo', '2fa:auth']
], function () {
    // CONFIRMACIÓN DE ACCIÓN (CONSTRASEÑA)
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // NUEVA CONTRASEÑA
    Route::get('cambio-pass', [NewPasswordController::class, 'cambioPass'])->name('password.change');
    Route::post('cambio-pass', [NewPasswordController::class, 'changePass']);

    // CERRAR SESIÓN
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
