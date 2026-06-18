<?php

namespace App\Http\Controllers\Admin\Configuraciones;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;

class GestionarModuloController extends Controller
{
    public function __invoke($clave)
    {
        $titulos = [
            'cuenta_individual' => 'Cuenta Individual',
            'pensionados' => 'Pensionados',
            'tiuna' => 'Tiuna',
            'registro_tiuna' => 'Registro Tiuna',
            'servicios_funcionario' => 'Servicios al Funcionario',
            'locacion_geografica' => 'Locación Geográfica',
        ];
        
        $imagenesDefecto = [
            'cuenta_individual' => 'img/imagen.png',
            'pensionados' => 'img/MAGALLY-2-1.jpg',
            'tiuna' => 'img/marcha-2.jpg',
            'registro_tiuna' => 'img/MAGALLY-2-2.jpg',
            'servicios_funcionario' => 'img/n.jpg',
            'locacion_geografica' => 'img/imagen.jpg',
        ];

        if (!array_key_exists($clave, $titulos)) {
            abort(404);
        }

        $titulo = $titulos[$clave];
        $config = Configuracion::where('clave', $clave)->first();
        
        if ($config && $config->valor) {
            $imagenActual = asset('storage/' . $config->valor);
            $esDefecto = false;
        } else {
            $imagenActual = asset($imagenesDefecto[$clave]);
            $esDefecto = true;
        }

        return view('admin.seccion', compact('clave', 'titulo', 'imagenActual', 'esDefecto'));
    }
}
