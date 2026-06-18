<?php

use Illuminate\Support\Facades\Route;

// AUTENTICACIÓN
require __DIR__ . '/auth.php';

Route::group([
    'middleware' => ['auth', 'auth.activo', 'auth.cambio_pass']
], function () {
    // 2FA
    require __DIR__ . '/two-factor.php';

    Route::group([
        'middleware' => ['2fa:auth']
    ], function () {
        // PANEL ADMINISTRATIVO
        require __DIR__ . '/admin.php';


        // SISTEMA
        require __DIR__ . '/sistema.php';
        // USUARIOS (perfil + gestión)
        require __DIR__ . '/usuarios.php';
    });
});

// PÁGINA WEB PÚBLICA (sin auth)
require __DIR__ . '/publica.php';
