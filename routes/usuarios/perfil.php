<?php

use App\Http\Controllers\Auth\Authenticator2faController;
use App\Http\Controllers\Auth\Telegram2faController;
use App\Http\Controllers\Usuario\PerfilController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'perfil',
    'controller' => PerfilController::class,
    'as' => 'perfil.'
], function () {
    // DETALLE
    Route::get('', 'detalle')->name('detalle');
    // ACTUALIZA CONTRASEÑA
    Route::put('actualiza-pass', 'actualizaPass')->name('actualiza-pass');
    // 2FA CONFIGURACIÓN
    Route::group([
        'prefix' => '2fa',
        'as' => '2fa.'
    ], function () {
        // INFORMACIÓN 2FA
        Route::get('', [PerfilController::class, 'twoFacorAuth'])->name('informacion');
        // AUTHENTICATOR APP
        Route::group([
            'prefix' => 'authenticator-app',
            'controller' => Authenticator2faController::class,
            'as' => 'authenticator-app.'
        ], function () {
            // CONFIGURACIÓN
            Route::get('', 'configuracion')->name('configuracion');
            // HABILITAR
            Route::post('habilitar', 'habilitar')
                ->middleware(['2fa.disponible:authenticator', 'throttle:7,5'])
                ->name('habilitar');
            // DESHABILITAR
            Route::post('deshabilitar', 'deshabilitar')
                ->middleware(['2fa.disponible:authenticator', '2fa.activo:authenticator', 'throttle:7,5'])
                ->name('deshabilitar');
        });
        // TELEGRAM APP
        Route::group([
            'prefix' => 'telegram-app',
            'controller' => Telegram2faController::class,
            'as' => 'telegram-app.',
        ], function () {
            // CONFIGURACIÓN
            Route::get('', 'configuracion')->name('configuracion');
            // DESHABILITAR
            Route::post('deshabilitar', 'deshabilitar')
                ->middleware(['2fa.disponible:telegram', '2fa.activo:telegram', 'throttle:7,5'])
                ->name('deshabilitar');
        });
    });
});
