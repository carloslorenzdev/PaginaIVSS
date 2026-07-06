<?php

namespace App\Http\Controllers\Admin\Configuraciones;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;

class GestionarEnlacesController extends Controller
{
    public function __invoke()
    {
        if (!auth()->user()->can('configuracion.enlaces')) {
            abort(403, 'Acceso denegado: No tienes permiso para gestionar los enlaces dinámicos.');
        }

        $grupos = [
            'Redes Sociales' => [
                'url_instagram' => 'Instagram',
                'url_twitter' => 'X',
                'url_youtube' => 'Youtube',
                'url_tiktok' => 'TikTok',
                'url_telegram' => 'Telegram',
                'url_facebook' => 'Facebook',
                'url_threads' => 'Threads',
            ],
            'Servicios Principales' => [
                'url_tiuna' => 'Tiuna',
                'url_registro_tiuna' => 'Registro Tiuna',
            ],
            'Sistemas en Línea' => [
                'url_sistema_estado_cuenta' => 'Estado de Cuenta',
                'url_sistema_orden_pago' => 'Orden de Pago',
                'url_sistema_solvencias' => 'Solvencias Electrónicas',
                'url_sistema_indemnizaciones_diarias' => 'Indemnizaciones Diarias',
                'url_sistema_verificacion_solvencia' => 'Verificación de Solvencia',
                'url_sistema_indemnizaciones_unicas' => 'Indemnizaciones Únicas',
                'url_sistema_sigesp_v3' => 'Sigesp_v3',
                'url_sistema_sigesp_v4' => 'Sigesp_v4',
            ],
            'Constancias y Verificaciones' => [
                'url_constancia_cotizaciones' => 'Constancias: Cotizaciones',
                'url_constancia_pension' => 'Constancias: Pensión',
                'url_constancia_autorizacion' => 'Constancias: Autorizador Cobro',
                'url_verificacion_autorizacion' => 'Verificar Autorización Cobro',
                'url_verificacion_pension' => 'Verificar Constancia de Pensión',
                'url_verificacion_cotizacion' => 'Verificar Constancia Cotización',
            ],
            'Servicios al Funcionario' => [
                'url_verificacion_constancia' => 'Verificación de Constancia',
                'url_ingresa_correo' => 'Ingresa a tu Correo',
                'url_solicitudes_rrhh' => 'Solicitudes a RRHH',
                'url_consulta_prestaciones' => 'Consulta de Prestaciones Sociales',
            ]
        ];

        $todasLasClaves = [];
        foreach ($grupos as $grupo) {
            $todasLasClaves = array_merge($todasLasClaves, array_keys($grupo));
        }

        $enlaces = Configuracion::whereIn('clave', $todasLasClaves)->pluck('valor', 'clave')->toArray();

        return view('admin.configuraciones.enlaces', compact('grupos', 'enlaces'));
    }
}
