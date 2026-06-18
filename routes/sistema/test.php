<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

// TEST para saver si tiene conexion a BD
Route::get('test', function (Request $request) {
    $principal = $secundaria = [];

    try {
        $principal['pdo'] = DB::connection()->getPdo();
        $principal['mensaje'] = 'Conexión Exitosa';
        $principal['color'] = 'teal';
        $principal['pdo'] = null;
    } catch (\Throwable $th) {
        Log::error('Error al conectar a BD principal. ', [$th->getMessage()]);
        $principal['color'] = 'red';
        $principal['mensaje'] = 'Conexión Fallida';
        $principal['pdo'] = $request->user() ? $th->getMessage() : null;
    }

    try {
        $secundaria['pdo'] = DB::connection('oracle_consulta')->getPdo();
        $secundaria['mensaje'] = 'Conexión Exitosa';
        $secundaria['color'] = 'teal';
        $secundaria['pdo'] = null;
    } catch (\Throwable $th) {
        Log::error('Error al conectar a BD secundaria. ', [$th->getMessage()]);
        $secundaria['color'] = 'red';
        $secundaria['mensaje'] = 'Conexión Fallida';
        $secundaria['pdo'] = $request->user() ? $th->getMessage() : null;
    }

    return view('test', compact('principal', 'secundaria'));
})->name('test');
