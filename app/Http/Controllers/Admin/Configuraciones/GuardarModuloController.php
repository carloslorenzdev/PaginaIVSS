<?php

namespace App\Http\Controllers\Admin\Configuraciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\Configuraciones\GuardarModuloAction;

class GuardarModuloController extends Controller
{
    public function __invoke(Request $request, $clave, GuardarModuloAction $action)
    {
        $request->validate([
            'archivo' => 'required|image|max:51200'
        ]);

        $titulos = [
            'cuenta_individual', 'pensionados', 'tiuna', 'registro_tiuna', 'servicios_funcionario', 'locacion_geografica'
        ];

        if (!in_array($clave, $titulos)) {
            abort(404);
        }

        $action->execute($clave, $request->file('archivo'));

        return redirect()->back()->with('success', 'La imagen ha sido actualizada correctamente.');
    }
}
