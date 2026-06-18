<?php

namespace App\Http\Controllers\Admin\Configuraciones;

use App\Http\Controllers\Controller;
use App\Actions\Admin\Configuraciones\EliminarModuloAction;

class EliminarModuloController extends Controller
{
    public function __invoke($clave, EliminarModuloAction $action)
    {
        $titulos = [
            'cuenta_individual', 'pensionados', 'tiuna', 'registro_tiuna', 'servicios_funcionario', 'locacion_geografica'
        ];

        if (!in_array($clave, $titulos)) {
            abort(404);
        }

        $action->execute($clave);

        return redirect()->back()->with('success', 'La imagen ha sido eliminada y se ha restaurado la por defecto.');
    }
}
