<?php

namespace App\Http\Controllers\Admin\Configuraciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\Configuraciones\GuardarEnlacesAction;

class GuardarEnlacesController extends Controller
{
    public function __invoke(Request $request, GuardarEnlacesAction $action)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $grupos = [
            'Redes Sociales' => [
                'url_instagram', 'url_twitter', 'url_youtube', 'url_tiktok', 'url_telegram', 'url_facebook', 'url_threads'
            ],
            'Servicios Principales' => [
                'url_sistema_en_linea', 'url_ciudadano', 'url_pensionados', 'url_empleadores',
                'url_cuenta_individual', 'url_tiuna', 'url_registro_tiuna', 'url_farmacias', 'url_centros_salud', 'url_oficinas'
            ],
            'Sistemas en Línea' => [
                'url_sistema_estado_cuenta', 'url_sistema_orden_pago', 'url_sistema_solvencias',
                'url_sistema_indemnizaciones_diarias', 'url_sistema_verificacion_solvencia',
                'url_sistema_indemnizaciones_unicas', 'url_sistema_sigesp_v3', 'url_sistema_sigesp_v4'
            ],
            'Ciudadanos' => [
                'url_ciudadano_informacion', 'url_ciudadano_beneficio_medico', 'url_ciudadano_continuidad',
                'url_ciudadano_perdida_empleo', 'url_ciudadano_tramites'
            ],
            'Pensionados' => [
                'url_pensionados_informacion', 'url_pensionados_tipos', 'url_pensionados_exterior', 'url_pensionados_tramites'
            ],
            'Constancias y Verificaciones' => [
                'url_constancia_cotizaciones', 'url_constancia_pension', 'url_constancia_autorizacion',
                'url_verificacion_autorizacion', 'url_verificacion_pension', 'url_verificacion_cotizacion'
            ],
            'Servicios al Funcionario' => [
                'url_verificacion_constancia', 'url_ingresa_correo', 'url_solicitudes_rrhh', 'url_consulta_prestaciones'
            ]
        ];

        $claves = [];
        foreach ($grupos as $grupo) {
            $claves = array_merge($claves, $grupo);
        }

        $action->execute($request->all(), $claves);

        return redirect()->back()->with('success', 'Enlaces actualizados exitosamente.');
    }
}
