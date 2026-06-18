<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Publico\ObtenerInicioDataController;
use App\Http\Controllers\Publico\ObtenerTodasLasNoticiasController;
use App\Http\Controllers\Publico\ObtenerNoticiaPorSlugController;

/*
|--------------------------------------------------------------------------
| Rutas de la Página Web Pública del IVSS
|--------------------------------------------------------------------------
|
| Estas rutas son de acceso público, sin autenticación.
| Sirven la página web institucional del IVSS.
|
*/

// PÁGINA DE INICIO
Route::get('/', ObtenerInicioDataController::class)->name('inicio');

// QUIÉNES SOMOS
Route::view('/quienes-somos', 'quienes_somos')->name('quienes_somos');

// NOTICIAS PÚBLICAS
Route::get('/noticias', ObtenerTodasLasNoticiasController::class)->name('noticias.index');
Route::get('/noticia/{slug}', ObtenerNoticiaPorSlugController::class)->name('noticias.show');

// RUTA DE FALLBACK PARA IMÁGENES (por si falla el symlink de storage en Linux)
Route::get('/storage/{path}', function ($path) {
    $rutaAbsoluta = storage_path('app/public/' . $path);
    if (!file_exists($rutaAbsoluta)) {
        abort(404);
    }
    $file = \Illuminate\Support\Facades\File::get($rutaAbsoluta);
    $type = \Illuminate\Support\Facades\File::mimeType($rutaAbsoluta);
    $response = \Illuminate\Support\Facades\Response::make($file, 200);
    $response->header('Content-Type', $type);
    $response->header('Cache-Control', 'public, max-age=86400');
    return $response;
})->where('path', '.*');

Route::post('/consulta-pensionado', \App\Http\Controllers\Consultas\ConsultarPensionadoController::class)->name('consulta.pensionado');
Route::post('/consulta-orden-pago', \App\Http\Controllers\Consultas\ConsultarOrdenPagoController::class)->name('consulta.ordenpago');
Route::post('/consulta-cuenta-individual', \App\Http\Controllers\Consultas\ConsultarCuentaIndividualController::class)->name('consulta.cuenta_individual');

