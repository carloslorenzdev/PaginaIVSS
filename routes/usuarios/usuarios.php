<?php

use App\Http\Controllers\Usuario\ActualizarUsuarioController;
use App\Http\Controllers\Usuario\RegistrarUsuarioController;
use App\Http\Controllers\Usuario\SeguridadUsuarioController;
use App\Http\Controllers\Usuario\Usuario2faController;
use App\Http\Controllers\Usuario\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'usuarios',
    'middleware' => ['role:Admin|Director'],
    'controller' => UsuarioController::class,
    'as' => 'usuarios.',
], function () {
    // LISTADO
    Route::get('', 'listado')->name('listado');
    // REGISTRAR
    Route::get('registrar', [RegistrarUsuarioController::class, 'registrar'])->name('registrar');
    Route::post('registrar', [RegistrarUsuarioController::class, 'crear']);

    Route::group([
        'prefix' => '{usuario:usuario}',
        'middleware' => ['2fa:otp', 'password.confirm', 'usuario.activo']
    ], function () {
        //  EIDTAR
        Route::get('editar', [ActualizarUsuarioController::class, 'editar'])->name('editar');
        Route::put('editar', [ActualizarUsuarioController::class, 'actualizar']);
        // DESACTIVA 2FA
        Route::get('desactivar-2fa', [Usuario2faController::class, 'desactivar'])->name('desactivar-2fa');
        Route::post('desactivar-2fa', [Usuario2faController::class, 'desactivar2fa']);
        // BLOQUEAR
        Route::post('bloquear', [SeguridadUsuarioController::class, 'bloquear'])
            ->name('bloquear');
        // DESBLOQUEAR
        Route::post('desbloquear', [SeguridadUsuarioController::class, 'desbloquear'])
            ->withoutMiddleware('usuario.activo')
            ->name('desbloquear');
        // RESTABLECER
        Route::post('restablecer', [SeguridadUsuarioController::class, 'restablecer'])
            ->name('restablecer');
    });
    // DETALLE
    Route::get('{user:usuario}', 'detalle')->name('detalle');
    // OBSERVACIONES
    Route::get('{user:usuario}/observaciones', 'observaciones')->name('observaciones');
});
