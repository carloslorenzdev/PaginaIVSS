<?php

namespace App\Actions\Consultas;

use Illuminate\Support\Facades\Http;

class ConsultarCuentaIndividualAction
{
    public function execute(array $data)
    {
        $urls = [
            'http://www.ivss.gob.ve:28083/CuentaIndividualIntranet/CtaIndividual_PortalCTRL',
            'http://www.ivss.gob.ve:28083/CuentaIndividualIntranet/CtaIndividualCTRL',
            'http://ivss.gob.ve:28083/CuentaIndividualIntranet/CtaIndividual_PortalCTRL',
            'http://ivss.gob.ve:28083/CuentaIndividualIntranet/CtaIndividualCTRL'
        ];

        $html = null;
        $baseUrl = null;

        foreach ($urls as $url) {
            try {
                $response = Http::timeout(4)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
                        'Accept-Language' => 'es-419,es;q=0.9',
                        'Origin' => 'http://ivss.gob.ve',
                        'Referer' => 'http://ivss.gob.ve/',
                        'Connection' => 'keep-alive',
                        'Upgrade-Insecure-Requests' => '1',
                        'Cache-Control' => 'max-age=0',
                        'Expect' => '',
                    ])
                    ->asForm()
                    ->post($url, [
                        'Accion' => '',
                        'Accion1' => '',
                        'nacionalidad_aseg' => $data['nacionalidad'],
                        'cedula_aseg' => $data['cedula'],
                        'consultar' => 'Buscar',
                    ]);

                if ($response->successful()) {
                    $html = $response->body();
                    $parsedUrl = parse_url($url);
                    $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . ':' . $parsedUrl['port'] . '/CuentaIndividualIntranet/';
                    break;
                }
            } catch (\Exception $e) {
                // Continue to the next URL if it fails
                continue;
            }
        }

        if (!$html) {
            return ['success' => false, 'message' => 'Error: No se pudo conectar con los servidores del IVSS. Por favor intente más tarde.'];
        }

        // Convert encoding
        $html = mb_convert_encoding($html, 'UTF-8', 'ISO-8859-1');

        // Check for specific error alert (ignoring the copyright one)
        if (preg_match_all("/alert\(['\"](.*?)['\"]\)/i", $html, $matches)) {
            foreach ($matches[1] as $message) {
                if (!str_contains($message, 'Copyright - IVSS')) {
                    return ['success' => false, 'message' => $message];
                }
            }
        }

        // 1. Eliminar cualquier etiqueta <base> previa que apunte a puertos internos inaccesibles
        $html = preg_replace('/<base[^>]*>/i', '', $html);

        // 2. Eliminar enlaces a favicon y hojas de estilo externas bloqueadas o inaccesibles
        $html = preg_replace('/<link[^>]*favicon[^>]*>/i', '', $html);
        $html = preg_replace('/<link[^>]*rel=["\'](?:shortcut )?icon["\'][^>]*>/i', '', $html);
        $html = preg_replace('/<link[^>]*href=["\'][^"\']*estilo\.css[^"\']*["\'][^>]*>/i', '', $html);
        $html = preg_replace('/<link[^>]*href=["\'][^"\']*2808[0-9][^"\']*["\'][^>]*>/i', '', $html);

        // 3. Encabezado institucional oficial en Base64 (superior.jpg o cintillo-ivss.jpg)
        $headerFile = public_path('imagenes/superior.jpg');
        if (!file_exists($headerFile)) {
            $headerFile = public_path('imagenes/cintillo-ivss.jpg');
        }
        $headerBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($headerFile));
        // Reemplazar la imagen de cabecera por coincidencia en src o en alt (con o sin comillas)
        $html = preg_replace('/src=["\']?[^"\'\s>]*superior2\.png["\']?/i', 'src="' . $headerBase64 . '"', $html);
        $html = preg_replace('/src=["\']?[^"\'\s>]*cuentaindividual[^"\'\s>]*["\']?/i', 'src="' . $headerBase64 . '"', $html);
        $html = preg_replace('/src=["\']?[^"\'\s>]*superior\.jpg["\']?/i', 'src="' . $headerBase64 . '"', $html);
        $html = preg_replace('/<img([^>]*\balt=["\'][^"\']*cuentaindividual[^"\']*["\'][^>]*)src=["\'][^"\']*["\']/i', '<img$1src="' . $headerBase64 . '"', $html);

        // 4. Marca de agua o imagen antigua (marcaivss_01.JPG o marcaivss01.JPG) reemplazada por gif transparente
        $transparentGif = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
        $html = preg_replace('/((?:src|background)=)["\']?[^"\'\s>]*marcaivss[^"\'\s>]*["\']?/i', '$1"' . $transparentGif . '"', $html);

        // 5. Líneas divisorias decorativas en Base64 (bg_lineas.jpg, bg_lineas_med.jpg)
        $bgLineasFile = public_path('imagenes/bg_lineas.jpg');
        $bgLineasBase64 = file_exists($bgLineasFile)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($bgLineasFile))
            : $transparentGif;
        $html = preg_replace('/((?:src|background)=)["\']?[^"\'\s>]*bg_lineas\.jpg["\']?/i', '$1"' . $bgLineasBase64 . '"', $html);

        $bgLineasMedFile = public_path('imagenes/bg_lineas_med.jpg');
        $bgLineasMedBase64 = file_exists($bgLineasMedFile)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($bgLineasMedFile))
            : $transparentGif;
        $html = preg_replace('/((?:src|background)=)["\']?[^"\'\s>]*bg_lineas_med\.jpg["\']?/i', '$1"' . $bgLineasMedBase64 . '"', $html);

        // 6. Remover de forma segura todos los scripts heredados (evita eval, CSP y bloqueo de contenido)
        $html = preg_replace('/<script\b[^>]*>(?:(?!<\/script>)[\s\S])*?<\/script>/i', '', $html);

        // 7. Inyectar estilos CSS, fondo oficial y funciones nativas seguras (imprimir, cerrar)
        $fondoPath = public_path('imagenes/fondo-ivss.png');
        $bgWatermark = file_exists($fondoPath) ? base64_encode(file_get_contents($fondoPath)) : '';

        $customCss = "
<style>
    body {
        " . ($bgWatermark ? "background-image: linear-gradient(rgba(243, 244, 246, 0.88), rgba(243, 244, 246, 0.88)), url('data:image/png;base64,{$bgWatermark}') !important; background-size: cover !important; background-position: center !important; background-attachment: fixed !important;" : "background-color: #f8f9fa !important;") . "
        font-family: Arial, Helvetica, sans-serif !important;
        margin: 0;
        padding: 15px;
    }
    .estilo { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #000099; }
    .letraCampo { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #0000CC; }
    .letraTitulo { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #FFFFFF; text-align: left; }
    .letraRelleno { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; text-align: left; }
    .otraLetraCampo { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; text-align: right; }
    .estiloBoton { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; text-align: center; color: #000000; }
    .letraFecha { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #000066; }
    .letraTexto { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #000000; }
    .letraMenu { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; color: #000066; text-align: left; }
    .letraFechaEncab { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #FFFFFF; }
    .letraTituloDerecho { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; color: #4c6c8f; text-align: right; }
    .letraCombo { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; }
    .letraTabla { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; color: #000000; text-align: center; vertical-align: middle; background-color: #cfdced; }
</style>
<script>
    function imprimir() { window.print(); }
    function cerrar() { window.close(); }
    function salir() { window.close(); }
</script>
";
        if (stripos($html, '</head>') !== false) {
            $html = str_ireplace('</head>', $customCss . "\n</head>", $html);
        } else {
            $html = $customCss . "\n" . $html;
        }
        $html = preg_replace('/<body([^>]*)\s+background=["\'][^"\']*["\']/i', '<body$1', $html);
        $html = preg_replace('/<body([^>]*)\s+onload=["\'][^"\']*["\']/i', '<body$1', $html);

        // 8. Reemplazar cualquier imagen restante huérfana para evitar timeouts o peticiones directas
        $html = preg_replace('/src=["\'](?!data:)[^"\']*imagenes\/[^"\']*["\']/i', 'src="' . $transparentGif . '"', $html);
        $html = preg_replace('/src=["\'](?!data:)[^"\']*:2808[0-9][^"\']*["\']/i', 'src="' . $transparentGif . '"', $html);

        return ['success' => true, 'html' => $html];
    }
}
