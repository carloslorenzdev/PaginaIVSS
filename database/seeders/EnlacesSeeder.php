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
        $links = [
            // Sistemas en linea
            'url_sistema_estado_cuenta' => 'http://www.ivss.gob.ve:28081/consultasIntra/consultarEmpresaAccion.ivss',
            'url_sistema_orden_pago' => 'http://autoliquidacionv2.ivss.gob.ve:28081/FacturaDigitalOnline/BrowseReport',
            'url_sistema_solvencias' => 'http://autoliquidacionv2.ivss.gob.ve:28082/TiunaWeb/certificadoSolvenciaElectronico.htm',
            'url_sistema_indemnizaciones_diarias' => 'http://www.ivss.gob.ve:28082/IndemnizacionWeb/servicios/',
            'url_sistema_verificacion_solvencia' => 'http://www.ivss.gob.ve:28085/CESolvencia/configuracion/Default.html',
            'url_sistema_indemnizaciones_unicas' => 'http://www.ivss.gob.ve/imag/page/pdf/PAGO UNICO DICIEMBRE 2016.pdf',
            
            // Consultas
            'url_cuenta_individual' => 'http://www.ivss.gob.ve:28083/CuentaIndividualIntranet/',
            'url_pensionados_informacion' => 'http://www.ivss.gob.ve:28080/Pensionado/PensionadoCTRL',
            
            // Sistema Tiuna (Empleadores)
            'url_tiuna' => 'http://autoliquidacionv2.ivss.gob.ve:28080/TiunaWeb/login.htm',
            'url_registro_tiuna' => 'http://registro.ivss.gob.ve:28085/RegistroSolicitudTiuna/home.htm',

            // Servicios Complementarios y Verificaciones
            'url_constancia_cotizaciones' => 'http://www.ivss.gob.ve:28088/ConstanciaCotizacion/',
            'url_constancia_autorizacion' => 'http://www.ivss.gob.ve:28089/AutorizaCobroPagoWeb/SolicitudAutorizacion.jsp',
            'url_verificacion_autorizacion' => 'http://www.ivss.gob.ve:28089/AutorizaCobroPagoWeb/VerificarAutorizacion.jsp',
            'url_verificacion_pension' => 'http://www.ivss.gob.ve:28087/Constanciapension/verificarConstancia.ivss',
            'url_verificacion_cotizacion' => 'http://www.ivss.gob.ve:28088/ConstanciaCotizacion/verificarConstancia.ivss',
            'url_marco_normativo' => 'http://www.ivss.gov.ve/aplicacion/biblioteca/',
            'url_biblioteca_formas' => 'http://www.ivss.gov.ve/aplicacion/biblioteca/formas',
            'url_contrataciones_publicas' => 'http://www.ivss.gov.ve/aplicacion/contratacion/',
            'url_farmapatria' => 'http://www.farmapatria.com.ve/',
            'url_boletin_informativo' => 'http://www.ivss.gov.ve/aplicacion/boletin/',
            'url_revista' => 'http://www.ivss.gov.ve/aplicacion/revista/',
            
            // Constancia y Autorizaciones
            'url_constancia_pension' => 'http://www.ivss.gob.ve:28087/Constanciapension/constanciaPension.ivss',
            
            // Ciudadanos
            'url_ciudadano_continuidad' => 'http://registronodependientes.ivss.int/',
            'url_ciudadano_perdida_empleo' => 'http://sappie.ivss.int:28081/Sappie/',
            'url_ciudadano_beneficio_medico' => 'http://historiasmedicas.ivss.int:28083/Historias Medicas/',
            'url_ciudadano_tramites' => 'http://ciudadano.ivss.int',
            
            // Otros
            'url_sistema_en_linea' => 'http://www.ivss.gob.ve',
            'url_ciudadano' => 'http://www.ivss.gob.ve',
            'url_pensionados' => 'http://www.ivss.gob.ve',
            'url_empleadores' => 'http://www.ivss.gob.ve',

            // Redes Sociales Nuevas
            'url_telegram' => '#',
            'url_facebook' => '#',
            'url_threads' => '#'
        ];

        foreach ($links as $clave => $valor) {
            Configuracion::updateOrCreate(
                ['clave' => $clave],
                ['valor' => $valor]
            );
        }
    }
}
