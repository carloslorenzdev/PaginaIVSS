<?php

use App\Http\Controllers\Sistema\CacheController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'cache',
    'controller' => CacheController::class,
    'as' => 'cache.',
], function () {
    // LIMPIAR
    Route::get('limpiar', 'limpiar')->name('limpiar');
});
