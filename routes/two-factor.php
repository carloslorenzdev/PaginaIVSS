<?php

use App\Http\Controllers\Auth\Telegram2faController;
use App\Http\Controllers\Auth\TwoFactorAuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '2fa',
    'middleware' => ['2fa.disponible', '2fa.habilitado'],
    'as' => '2fa.'
], function () {
    // SELECCION DE 2FA
    Route::get('metodo', [TwoFactorAuthController::class, 'metodo'])
        ->middleware('signed')->name('selecciona-metodo');
    // VALIDA CÓDIGO SEGÚN MÉTODO SELECCIONADO
    Route::get('verificar/{metodo}', [TwoFactorAuthController::class, 'verificar'])
        ->middleware(['2fa.disponible:metodo', 'signed'])->name('verificar');
    Route::post('verificar/{metodo}', [TwoFactorAuthController::class, 'verifyOtp'])
        ->middleware(['2fa.disponible:metodo', 'signed']);
    // ENVIA CÓDIGO OTP VIA TELEGRAM APP
    Route::get('telegram/enviar-codigo', [Telegram2faController::class, 'enviaOTP'])
        ->middleware(['2fa.disponible:telegram', '2fa.activo:telegram'])->name('telegram.envia-otp');
});
