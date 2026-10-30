<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuracion;

class EnlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Eliminar Orden de Pago de enlaces dinámicos (ahora opera vía modal de consulta interna)
        Configuracion::where('clave', 'url_sistema_orden_pago')->delete();
        Configuracion::where('clave', 'visible_url_sistema_orden_pago')->delete();

        // 2. Reparar URLs corruptas que tengan doble puerto o IP de la aplicación inyectada erróneamente
        $corruptas = Configuracion::where('valor', 'like', '%200.109.237.57:9090:%')
            ->orWhere('valor', 'like', '%:9090:280%')
            ->get();
        foreach ($corruptas as $item) {
            $item->valor = preg_replace('/https?:\/\/200\.109\.237\.57:9090:(\d+)/', 'http://www.ivss.gob.ve:$1', $item->valor);
            $item->save();
        }

        // 3. URLs institucionales oficiales y verificadas
        $links = [
            // Redes Sociales
            'url_instagram' => 'https://www.instagram.com/ivss_ve/',
            'url_twitter' => 'https://x.com/IVSS_ve',
            'url_youtube' => 'https://www.youtube.com/@IVSS_AUDIOVISUALES',
            'url_tiktok' => 'https://www.tiktok.com/@ivss_ve',
            'url_telegram' => 'https://t.me/IVSSOFICIAL',
            'url_facebook' => 'https://www.facebook.com/share/1E1jAipoS2/',
            'url_threads' => 'https://www.threads.com/@ivss_ve',

            // Servicios Principales
            'url_tiuna' => 'http://autoliquidacionv2.ivss.gob.ve:28080/TiunaWeb/login.htm',
            'url_registro_tiuna' => 'http://registro.ivss.gob.ve:28085/RegistroSolicitudTiuna/home.htm',

            // Sistemas en Línea
            'url_sistema_estado_cuenta' => 'http://www.ivss.gob.ve:28081/consultasIntra/consultarEmpresaAccion.ivss',
            'url_sistema_solvencias' => 'http://autoliquidacionv2.ivss.gob.ve:28082/TiunaWeb/certificadoSolvenciaElectronico.htm',
            'url_sistema_indemnizaciones_diarias' => 'http://www.ivss.gob.ve:28082/IndemnizacionWeb/servicios/',
            'url_sistema_verificacion_solvencia' => 'http://www.ivss.gob.ve:28085/CESolvencia/configuracion/Default.html',
            'url_sistema_indemnizaciones_unicas' => 'http://www.ivss.gob.ve/imag/page/pdf/PAGO UNICO DICIEMBRE 2016.pdf',
            'url_sistema_sigesp_v3' => 'https://sigesp.mpp.gob.ve/sigesp/v3/',
            'url_sistema_sigesp_v4' => 'https://sigesp.mpp.gob.ve/sigesp/v4/',

            // Constancias y Verificaciones
            'url_constancia_cotizaciones' => 'http://www.ivss.gob.ve:28088/ConstanciaCotizacion/',
            'url_constancia_pension' => 'http://www.ivss.gob.ve:28087/Constanciapension/constanciaPension.ivss',
            'url_constancia_autorizacion' => 'http://www.ivss.gob.ve:28089/AutorizaCobroPagoWeb/SolicitudAutorizacion.jsp',
            'url_verificacion_autorizacion' => 'http://www.ivss.gob.ve:28089/AutorizaCobroPagoWeb/VerificarAutorizacion.jsp',
            'url_verificacion_pension' => 'http://www.ivss.gob.ve:28087/Constanciapension/verificarConstancia.ivss',
            'url_verificacion_cotizacion' => 'http://www.ivss.gob.ve:28088/ConstanciaCotizacion/verificarConstancia.ivss',

            // Servicios al Funcionario
            'url_verificacion_constancia' => 'https://ejemplo.com',
            'url_ingresa_correo' => 'https://correo.ivss.gob.ve/',
            'url_solicitudes_rrhh' => 'http://www.ivss.gob.ve:28084/Comprobante/',
            'url_consulta_prestaciones' => 'http://consultaprestacionesrrhh.ivss.gob.ve:90/',

            // Consultas complementarias
            'url_cuenta_individual' => 'http://www.ivss.gob.ve:28083/CuentaIndividualIntranet/',
            'url_pensionados_informacion' => 'http://www.ivss.gob.ve:28080/Pensionado/PensionadoCTRL',
            'url_ciudadano_continuidad' => 'http://registronodependientes.ivss.int/',
            'url_ciudadano_perdida_empleo' => 'http://sappie.ivss.int:28081/Sappie/',
            'url_ciudadano_beneficio_medico' => 'http://historiasmedicas.ivss.int:28083/Historias Medicas/',
            'url_ciudadano_tramites' => 'http://ciudadano.ivss.int',
            'url_marco_normativo' => 'http://www.ivss.gov.ve/aplicacion/biblioteca/',
            'url_biblioteca_formas' => 'http://www.ivss.gov.ve/aplicacion/biblioteca/formas',
            'url_contrataciones_publicas' => 'http://www.ivss.gov.ve/aplicacion/contratacion/',
            'url_farmapatria' => 'http://www.farmapatria.com.ve/',
            'url_boletin_informativo' => 'http://www.ivss.gov.ve/aplicacion/boletin/',
            'url_revista' => 'http://www.ivss.gov.ve/aplicacion/revista/',
        ];

        foreach ($links as $clave => $valor) {
            Configuracion::updateOrCreate(
                ['clave' => $clave],
                ['valor' => $valor]
            );

            // Garantizar visibilidad activa (1) por defecto si aún no está configurada
            Configuracion::firstOrCreate(
                ['clave' => 'visible_' . $clave],
                ['valor' => '1']
            );
        }
    }
}
