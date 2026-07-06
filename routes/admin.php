<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas del Panel Administrativo - Página Web IVSS
|--------------------------------------------------------------------------
|
| Todas estas rutas requieren auth + 2FA (heredado del grupo en web.php).
| Se protegen además con middleware de permisos Spatie.
|
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // DASHBOARD / PANEL
    Route::get('/panel', \App\Http\Controllers\Admin\Noticias\ListarNoticiasPanelController::class)->name('panel');

    // ----------------------------------------------------------------
    // NOTICIAS
    // ----------------------------------------------------------------
    Route::prefix('noticias')->name('noticias.')->group(function () {
        Route::get('/crear', \App\Http\Controllers\Admin\Noticias\CrearNoticiaViewController::class)->name('crear');
        Route::post('/guardar', \App\Http\Controllers\Admin\Noticias\GuardarNoticiaController::class)->name('guardar');
        Route::post('/{id}/publicar', \App\Http\Controllers\Admin\Noticias\TogglePublicacionNoticiaController::class)->name('publicar');
        Route::get('/{id}', \App\Http\Controllers\Admin\Noticias\VerNoticiaPanelController::class)->name('ver');
        Route::put('/{noticia}', \App\Http\Controllers\Admin\Noticias\ActualizarNoticiaController::class)->name('actualizar');
        Route::delete('/{id}', \App\Http\Controllers\Admin\Noticias\EliminarNoticiaController::class)->name('eliminar');
        Route::post('/{id}/subir-medio', \App\Http\Controllers\Admin\Noticias\SubirMedioNoticiaController::class)->name('subir-medio');
        Route::delete('/{noticiaId}/medios/{medioId}', \App\Http\Controllers\Admin\Noticias\EliminarMedioNoticiaController::class)->name('eliminar-medio');
    });

    // ----------------------------------------------------------------
    // CATEGORÍAS
    // ----------------------------------------------------------------
    Route::prefix('categorias')->name('categorias.')->group(function () {
        Route::get('/', \App\Http\Controllers\Admin\Categorias\ListarCategoriasController::class)->name('index');
        Route::get('/crear', \App\Http\Controllers\Admin\Categorias\CrearCategoriaViewController::class)->name('crear');
        Route::post('/guardar', \App\Http\Controllers\Admin\Categorias\GuardarCategoriaController::class)->name('guardar');
        Route::get('/{id}/editar', \App\Http\Controllers\Admin\Categorias\EditarCategoriaViewController::class)->name('editar');
        Route::put('/{id}', \App\Http\Controllers\Admin\Categorias\ActualizarCategoriaController::class)->name('actualizar');
        Route::delete('/{id}', \App\Http\Controllers\Admin\Categorias\EliminarCategoriaController::class)->name('eliminar');
    });

    // ----------------------------------------------------------------
    // CARRUSEL
    // ----------------------------------------------------------------
    Route::prefix('carrusel')->name('carrusel.')->group(function () {
        Route::get('/', \App\Http\Controllers\Admin\Carrusel\GestionarCarruselController::class)->name('gestionar');
        Route::post('/', \App\Http\Controllers\Admin\Carrusel\GuardarCarruselController::class)->name('guardar');
        Route::post('/velocidad', \App\Http\Controllers\Admin\Carrusel\GuardarVelocidadCarruselController::class)->name('velocidad');
        Route::put('/{id}', \App\Http\Controllers\Admin\Carrusel\ActualizarCarruselController::class)->name('actualizar');
        Route::delete('/{id}', \App\Http\Controllers\Admin\Carrusel\EliminarCarruselController::class)->name('eliminar');
    });

    // ----------------------------------------------------------------
    // ACTIVIDADES ANUALES
    // ----------------------------------------------------------------
    Route::prefix('actividades')->name('actividades.')->group(function () {
        Route::get('/', \App\Http\Controllers\Admin\ActividadesAnuales\ListarActividadesAnualesController::class)->name('index');
        Route::get('/crear', \App\Http\Controllers\Admin\ActividadesAnuales\CrearActividadAnualViewController::class)->name('crear');
        Route::post('/guardar', \App\Http\Controllers\Admin\ActividadesAnuales\GuardarActividadAnualController::class)->name('guardar');
        Route::get('/{id}', \App\Http\Controllers\Admin\ActividadesAnuales\VerActividadAnualController::class)->name('ver');
        Route::put('/{id}', \App\Http\Controllers\Admin\ActividadesAnuales\ActualizarActividadAnualController::class)->name('actualizar');
        Route::delete('/{id}', \App\Http\Controllers\Admin\ActividadesAnuales\EliminarActividadAnualController::class)->name('eliminar');
        Route::post('/{id}/subir-medio', \App\Http\Controllers\Admin\ActividadesAnuales\SubirMedioActividadController::class)->name('subir-medio');
        Route::delete('/{actividadId}/medios/{medioId}', \App\Http\Controllers\Admin\ActividadesAnuales\EliminarMedioActividadController::class)->name('eliminar-medio');
    });

    // ----------------------------------------------------------------
    // CONFIGURACIÓN VISUAL
    // ----------------------------------------------------------------
    Route::prefix('configuracion')->name('config.')->group(function () {
        Route::get('/visual', \App\Http\Controllers\Admin\Configuraciones\VisualConfigIndexController::class)->name('visual');
        Route::post('/visual/membrete', \App\Http\Controllers\Admin\Configuraciones\UpdateMembreteController::class)->name('visual.membrete');
        Route::post('/visual/carrusel-estilo', \App\Http\Controllers\Admin\Configuraciones\UpdateCarruselEstiloController::class)->name('visual.carrusel');
        Route::post('/visual/backgrounds', \App\Http\Controllers\Admin\Configuraciones\UpdateBackgroundsController::class)->name('visual.backgrounds');
        Route::get('/enlaces', \App\Http\Controllers\Admin\Configuraciones\GestionarEnlacesController::class)->name('enlaces');
        Route::post('/enlaces', \App\Http\Controllers\Admin\Configuraciones\GuardarEnlacesController::class)->name('enlaces.guardar');
        Route::get('/modulo/{clave}', \App\Http\Controllers\Admin\Configuraciones\GestionarModuloController::class)->name('modulo');
        Route::post('/modulo/{clave}', \App\Http\Controllers\Admin\Configuraciones\GuardarModuloController::class)->name('modulo.guardar');
        Route::delete('/modulo/{clave}', \App\Http\Controllers\Admin\Configuraciones\EliminarModuloController::class)->name('modulo.eliminar');

    });

    // ----------------------------------------------------------------
    // BOLETINES INFORMATIVOS
    // ----------------------------------------------------------------
    Route::prefix('boletines')->name('boletines.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\Boletines\BoletinAdminController::class, 'index'])->name('index');
        Route::get('/crear', [\App\Http\Controllers\Admin\Boletines\BoletinAdminController::class, 'crear'])->name('crear');
        Route::post('/guardar', [\App\Http\Controllers\Admin\Boletines\BoletinAdminController::class, 'guardar'])->name('guardar');
        Route::get('/{boletin}', [\App\Http\Controllers\Admin\Boletines\BoletinAdminController::class, 'ver'])->name('ver');
        Route::put('/{boletin}', [\App\Http\Controllers\Admin\Boletines\BoletinAdminController::class, 'actualizar'])->name('actualizar');
        Route::delete('/{boletin}', [\App\Http\Controllers\Admin\Boletines\BoletinAdminController::class, 'eliminar'])->name('eliminar');
        Route::post('/{boletin}/publicar', [\App\Http\Controllers\Admin\Boletines\BoletinAdminController::class, 'togglePublicacion'])->name('publicar');
    });

    // ----------------------------------------------------------------
    // REVISTAS DIGITALES
    // ----------------------------------------------------------------
    Route::prefix('revistas')->name('revistas.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\Revistas\RevistaAdminController::class, 'index'])->name('index');
        Route::get('/crear', [\App\Http\Controllers\Admin\Revistas\RevistaAdminController::class, 'crear'])->name('crear');
        Route::post('/guardar', [\App\Http\Controllers\Admin\Revistas\RevistaAdminController::class, 'guardar'])->name('guardar');
        Route::get('/{revista}', [\App\Http\Controllers\Admin\Revistas\RevistaAdminController::class, 'ver'])->name('ver');
        Route::put('/{revista}', [\App\Http\Controllers\Admin\Revistas\RevistaAdminController::class, 'actualizar'])->name('actualizar');
        Route::delete('/{revista}', [\App\Http\Controllers\Admin\Revistas\RevistaAdminController::class, 'eliminar'])->name('eliminar');
        Route::post('/{revista}/publicar', [\App\Http\Controllers\Admin\Revistas\RevistaAdminController::class, 'togglePublicacion'])->name('publicar');
    });

    // ----------------------------------------------------------------
    // BANNERS Y ALERTAS
    // ----------------------------------------------------------------
    Route::prefix('banners')->name('banners.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\BannerController::class, 'index'])->name('index');
        
        // Alerta
        Route::post('/alerta', [\App\Http\Controllers\Admin\BannerController::class, 'updateAlerta'])->name('updateAlerta');
        Route::post('/alerta/clear', [\App\Http\Controllers\Admin\BannerController::class, 'clearAlerta'])->name('clearAlerta');
        
        // Carrusel (Banners)
        Route::post('/', [\App\Http\Controllers\Admin\BannerController::class, 'store'])->name('store');
        Route::delete('/{banner}', [\App\Http\Controllers\Admin\BannerController::class, 'destroy'])->name('destroy');
    });

    // ----------------------------------------------------------------
    // DIRECTORIOS DE SALUD Y ADMINISTRATIVOS
    // ----------------------------------------------------------------
    Route::prefix('directorios')->name('directorios.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DirectorioController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\Admin\DirectorioController::class, 'store'])->name('store');
        Route::put('/{directorio}', [\App\Http\Controllers\Admin\DirectorioController::class, 'update'])->name('update');
        Route::delete('/{directorio}', [\App\Http\Controllers\Admin\DirectorioController::class, 'destroy'])->name('destroy');
    });

    // ----------------------------------------------------------------
    // RENDIMIENTO / LOGS
    // ----------------------------------------------------------------
    Route::get('/rendimiento', [\App\Http\Controllers\Admin\RendimientoController::class, 'index'])->name('rendimiento');
    Route::post('/rendimiento/optimizar', [\App\Http\Controllers\Admin\RendimientoController::class, 'optimizar'])->name('rendimiento.optimizar');
    Route::get('/logs', \App\Http\Controllers\Admin\LogsController::class)->name('logs');

    // ----------------------------------------------------------------
    // BASE DE CONOCIMIENTO (CHATBOT)
    // ----------------------------------------------------------------
    Route::prefix('chatbot')->name('chatbot.')->group(function () {
        Route::resource('conocimiento', \App\Http\Controllers\Admin\ChatbotConocimientoController::class)->except(['create', 'show', 'edit']);
        Route::resource('preguntas-sin-respuesta', \App\Http\Controllers\Admin\ChatbotPreguntaSinRespuestaController::class)->only(['index', 'destroy']);
    });

    // ----------------------------------------------------------------
    // BACKUPS (RESPALDOS)
    // ----------------------------------------------------------------
    Route::prefix('backups')->name('backups.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\BackupController::class, 'index'])->name('index');
        Route::post('/run', [\App\Http\Controllers\Admin\BackupController::class, 'run'])->name('run');
        Route::get('/download/{file_name}', [\App\Http\Controllers\Admin\BackupController::class, 'download'])->name('download');
        Route::delete('/delete/{file_name}', [\App\Http\Controllers\Admin\BackupController::class, 'delete'])->name('delete');
    });
});
