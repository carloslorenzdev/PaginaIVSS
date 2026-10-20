<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas de la Página Web Pública del IVSS (Livewire 4 SPA)
|--------------------------------------------------------------------------
|
| Todas las rutas públicas operan ahora como componentes Livewire 4
| de página completa, permitiendo navegación SPA fluida e instantánea
| con wire:navigate sin recargas de página.
|
*/

// PÁGINA DE INICIO (Livewire 4 Page Component)
Route::get('/', \App\Livewire\Publico\Inicio::class)->name('inicio');

// QUIÉNES SOMOS (Livewire 4 Page Component)
Route::get('/quienes-somos', \App\Livewire\Publico\QuienesSomos::class)->name('quienes_somos');

// NOTICIAS PÚBLICAS (Livewire 4 Page Component)
Route::get('/noticias', \App\Livewire\NoticiasSearch::class)->name('noticias.index');
Route::get('/noticia/{slug}', \App\Livewire\Publico\NoticiaDetalle::class)->name('noticias.show');


// RUTA DE FALLBACK PARA ARCHIVOS PÚBLICOS (Protegida contra Path Traversal CWE-22)
Route::get('/storage/{path}', function ($path) {
    $basePath = realpath(storage_path('app/public'));
    $rutaAbsoluta = realpath(storage_path('app/public/' . $path));

    // Validar que la ruta resuelta exista, sea un archivo y resida estrictamente dentro de storage/app/public
    if (!$basePath || !$rutaAbsoluta || !str_starts_with($rutaAbsoluta, $basePath) || !is_file($rutaAbsoluta)) {
        abort(404);
    }

    $file = \Illuminate\Support\Facades\File::get($rutaAbsoluta);
    $type = \Illuminate\Support\Facades\File::mimeType($rutaAbsoluta);
    $response = \Illuminate\Support\Facades\Response::make($file, 200);
    $response->header('Content-Type', $type);
    $response->header('Cache-Control', 'public, max-age=86400');
    return $response;
})->where('path', '.*');

// CONSULTAS PÚBLICAS
Route::post('/consulta-pensionado', \App\Http\Controllers\Consultas\ConsultarPensionadoController::class)->name('consulta.pensionado');
Route::post('/consulta-orden-pago', \App\Http\Controllers\Consultas\ConsultarOrdenPagoController::class)->name('consulta.ordenpago');
Route::post('/consulta-cuenta-individual', \App\Http\Controllers\Consultas\ConsultarCuentaIndividualController::class)->name('consulta.cuenta_individual');

// SERVICIOS COMPLEMENTARIOS (Livewire 4 Page Components)
Route::get('/marco-normativo', \App\Livewire\Publico\MarcoNormativo::class)->name('marco_normativo');
Route::get('/biblioteca-formas', \App\Livewire\Publico\BibliotecaFormas::class)->name('biblioteca_formas');
Route::get('/contrataciones-publicas', \App\Livewire\Publico\ContratacionesPublicas::class)->name('contrataciones_publicas');
Route::get('/boletin-informativo', \App\Livewire\Publico\BoletinesPublicos::class)->name('boletin_informativo');
Route::get('/revista-digital', \App\Livewire\Publico\RevistasPublicas::class)->name('revista_digital');
Route::get('/revista-digital/{revista}', \App\Livewire\Publico\RevistaShow::class)->name('revista_digital.show');

// CIUDADANOS (Livewire 4 Page Components)
Route::get('/ciudadano/informacion-general', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'ciudadanos_informacion_general')
    ->defaults('titulo', 'Información General del Ciudadano - IVSS')
    ->name('ciudadano.informacion');

Route::get('/ciudadano/beneficio-medico', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'ciudadanos_beneficio_medico')
    ->defaults('titulo', 'Beneficio Médico Integral - IVSS')
    ->name('ciudadano.beneficio');

Route::get('/ciudadano/continuidad-facultativa', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'ciudadanos_continuidad_facultativa')
    ->defaults('titulo', 'Continuidad Facultativa - IVSS')
    ->name('ciudadano.continuidad');

Route::get('/ciudadano/perdida-empleo', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'ciudadanos_perdida_empleo')
    ->defaults('titulo', 'Pérdida Involuntaria de Empleo - IVSS')
    ->name('ciudadano.perdida');

Route::get('/ciudadano/tramites', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'ciudadanos_tramites')
    ->defaults('titulo', 'Trámites del Ciudadano - IVSS')
    ->name('ciudadano.tramites');

// PENSIONADOS (Livewire 4 Page Components)
Route::get('/pensionado/informacion-general', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'pensionados_informacion_general')
    ->defaults('titulo', 'Información General - Pensionados IVSS')
    ->name('pensionado.informacion');

Route::get('/pensionado/tipos-pensiones', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'pensionados_tipos_pensiones')
    ->defaults('titulo', 'Tipos de Pensiones - IVSS')
    ->name('pensionado.tipos_pensiones');

Route::get('/pensionado/pensionados-exterior', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'pensionados_pensionados_exterior')
    ->defaults('titulo', 'Pensionados en el Exterior - IVSS')
    ->name('pensionado.pensionados_exterior');

Route::get('/pensionado/tramites', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'pensionados_tramites')
    ->defaults('titulo', 'Trámites de Pensionados - IVSS')
    ->name('pensionado.tramites');

Route::get('/pensionado/contacto', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'pensionados_contacto')
    ->defaults('titulo', 'Contacto Pensionados Exterior - IVSS')
    ->name('pensionado.contacto');

Route::get('/pensionado/formularios', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'pensionados_formularios')
    ->defaults('titulo', 'Formularios Pensionados Exterior - IVSS')
    ->name('pensionado.formularios');

// EMPLEADORES (Livewire 4 Page Components)
Route::get('/empleador/informacion-general', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'empleadores_informacion_general')
    ->defaults('titulo', 'Información General - Empleadores IVSS')
    ->name('empleador.informacion');

Route::get('/empleador/quien-es', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'empleadores_quien_es')
    ->defaults('titulo', '¿Quién es el Empleador(a)? - IVSS')
    ->name('empleador.quien_es');

Route::get('/empleador/tipos-empresas', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'empleadores_tipos_empresas')
    ->defaults('titulo', 'Tipos de Empresas - IVSS')
    ->name('empleador.tipos_empresas');

Route::get('/empleador/sistema-autoliquidacion', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'empleadores_sistema_autoliquidacion')
    ->defaults('titulo', 'Sistema de Autoliquidación - IVSS')
    ->name('empleador.sistema_autoliquidacion');

Route::get('/empleador/tramites', \App\Livewire\Publico\PaginaInformativa::class)
    ->defaults('seccion', 'empleadores_tramites')
    ->defaults('titulo', 'Trámites del Empleador - IVSS')
    ->name('empleador.tramites');

// DIRECTORIOS (Livewire 4 Page Components)
Route::get('/farmacias', \App\Livewire\DirectorioSearch::class)->defaults('tipo', 'farmacia')->name('farmacias');
Route::get('/centros-de-salud', \App\Livewire\DirectorioSearch::class)->defaults('tipo', 'centro_salud')->name('centros_salud');
Route::get('/oficinas-administrativas', \App\Livewire\DirectorioSearch::class)->defaults('tipo', 'oficina_administrativa')->name('oficinas_administrativas');


