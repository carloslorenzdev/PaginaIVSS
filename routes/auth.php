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

    // RECUPERAR CONTRASEÑA
    Route::get('recuperar-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'show'])->name('password.request');
    Route::post('recuperar-password/verificar-usuario', [\App\Http\Controllers\Auth\PasswordResetController::class, 'verificarUsuario'])->name('password.verify-user');
    Route::post('recuperar-password/verificar-codigo', [\App\Http\Controllers\Auth\PasswordResetController::class, 'verificarCodigo'])->name('password.verify-code');
    Route::post('recuperar-password/restablecer', [\App\Http\Controllers\Auth\PasswordResetController::class, 'restablecer'])->name('password.update');
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
});

Route::group([
    'middleware' => ['auth']
], function () {
    // CERRAR SESIÓN
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
