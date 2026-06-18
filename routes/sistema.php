<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'sistema',
    'middleware' => ['role:Admin'],
    'as' => 'sistema.',
], function () {
    // CACHE
    require __DIR__ . '/sistema/cache.php';
    // TEST BF
    require __DIR__ . '/sistema/test.php';
    // AUDIRORIA - HISTORICO (LARAVEL AUDITING)
    // AUDITORIA BD
});
