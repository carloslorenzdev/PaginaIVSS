<?php

namespace App\Http\Controllers\Admin\Configuraciones;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;

class GestionarEnlacesController extends Controller
{
    public function __invoke()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Acceso denegado: Solo el administrador puede gestionar los enlaces dinámicos.');
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
                'url_sistema_en_linea' => 'Sistema en Línea',
                'url_ciudadano' => 'Ciudadano',
                'url_pensionados' => 'Pensionados',
                'url_empleadores' => 'Empleadores',
                'url_cuenta_individual' => 'Cuenta Individual',
                'url_tiuna' => 'Tiuna',
                'url_registro_tiuna' => 'Registro Tiuna',
                'url_farmacias' => 'Farmacias de Alto Costo',
                'url_centros_salud' => 'Centros de Salud',
                'url_oficinas' => 'Oficinas Administrativas',
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
            'Ciudadanos' => [
                'url_ciudadano_informacion' => 'Información General',
                'url_ciudadano_beneficio_medico' => 'Beneficio Médico Integral',
                'url_ciudadano_continuidad' => 'Continuidad Facultativa',
                'url_ciudadano_perdida_empleo' => '¿Perdiste tu empleo?',
                'url_ciudadano_tramites' => 'Trámites',
            ],
            'Pensionados' => [
                'url_pensionados_informacion' => 'Información General',
                'url_pensionados_tipos' => 'Tipos de Pensiones',
                'url_pensionados_exterior' => 'Pensionados en el Exterior',
                'url_pensionados_tramites' => 'Trámites',
            ],
            'Constancias y Verificaciones' => [
                'url_constancia_cotizaciones' => 'Constancias: Cotizaciones',
                'url_constancia_pension' => 'Constancias: Pensión',
                'url_constancia_autorizacion' => 'Constancias: Autorizador Cobro',
                'url_verificacion_autorizacion' => 'Verificar Autorización Cobro',
                'url_verificacion_pension' => 'Verificar Constancia de Pensión',
                'url_verificacion_cotizacion' => 'Verificar Constancia Cotización',
            ],
            'Otros Enlaces' => [
                'url_marco_normativo' => 'Marco Normativo',
                'url_biblioteca_formas' => 'Biblioteca de Formas',
                'url_contrataciones_publicas' => 'Contrataciones Públicas',
                'url_farmapatria' => 'Farmapatria',
                'url_boletin_informativo' => 'Boletín Informativo',
                'url_revista' => 'Revista Digital'
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
