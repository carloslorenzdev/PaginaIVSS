<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Roles\RoleController;

Route::group(['middleware' => ['role:admin']], function () {
    Route::prefix('usuarios/roles')->name('usuarios.roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    });
});
