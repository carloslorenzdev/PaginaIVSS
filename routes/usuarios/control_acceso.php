<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Roles\ControlAccesoController;

Route::group(['middleware' => ['role:admin']], function () {
    Route::prefix('usuarios/control-acceso')->name('usuarios.control_acceso.')->group(function () {
        Route::get('/', [ControlAccesoController::class, 'index'])->name('index');
        Route::get('/{role}/editar', [ControlAccesoController::class, 'edit'])->name('edit');
        Route::put('/{role}', [ControlAccesoController::class, 'update'])->name('update');
    });
});
