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

        // 2. Eliminar enlaces a hojas de estilo externas bloqueadas o inaccesibles
        $html = preg_replace('/<link[^>]*href=["\'][^"\']*estilo\.css[^"\']*["\'][^>]*>/i', '', $html);
        $html = preg_replace('/<link[^>]*href=["\'][^"\']*2808[0-9][^"\']*["\'][^>]*>/i', '', $html);

        // 3. Encabezado institucional oficial en Base64 (superior2.png, cuentaindividual, o cintillo-ivss.jpg)
        $headerFile = public_path('imagenes/cintillo-ivss.jpg');
        if (!file_exists($headerFile)) {
            $headerFile = public_path('imagenes/superior.jpg');
        }
        $headerBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($headerFile));
        $html = preg_replace('/src=["\'][^"\']*(superior2|cuentaindividual)[^"\']*["\']/i', 'src="' . $headerBase64 . '"', $html);

        // 4. Marca de agua institucional (marcaivss01.JPG o marcaivss_01.JPG) en Base64
        $fondoPath = public_path('imagenes/fondo-ivss.png');
        $fondoBase64 = file_exists($fondoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($fondoPath)) : '';
        if ($fondoBase64) {
            $html = preg_replace('/(src|background)=["\'][^"\']*marcaivss[^"\']*["\']/i', '$1="' . $fondoBase64 . '"', $html);
        }

        // 5. Líneas divisorias decorativas en Base64 (bg_lineas.jpg, bg_lineas_med.jpg)
        $bgLineasFile = public_path('imagenes/bg_lineas.jpg');
        $bgLineasBase64 = file_exists($bgLineasFile)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($bgLineasFile))
            : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
        $html = preg_replace('/(src|background)=["\'][^"\']*bg_lineas\.jpg[^"\']*["\']/i', '$1="' . $bgLineasBase64 . '"', $html);

        $bgLineasMedFile = public_path('imagenes/bg_lineas_med.jpg');
        $bgLineasMedBase64 = file_exists($bgLineasMedFile)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($bgLineasMedFile))
            : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
        $html = preg_replace('/(src|background)=["\'][^"\']*bg_lineas_med\.jpg[^"\']*["\']/i', '$1="' . $bgLineasMedBase64 . '"', $html);

        // 6. Inyectar estilos CSS y marca de agua institucional como Base64 (sin peticiones de red externas)
        $customCss = "
<style>
    body {
        " . ($fondoBase64 ? "background-image: url('{$fondoBase64}') !important; background-repeat: repeat !important; background-position: center top !important;" : "") . "
        font-family: Arial, Helvetica, sans-serif !important;
        margin: 0;
        padding: 10px;
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
";
        if (stripos($html, '</head>') !== false) {
            $html = str_ireplace('</head>', $customCss . "\n</head>", $html);
        } else {
            $html = $customCss . "\n" . $html;
        }
        $html = preg_replace('/<body([^>]*)\s+background=["\'][^"\']*["\']/i', '<body$1', $html);

        // 7. Reemplazar cualquier imagen restante huérfana para evitar timeouts o peticiones directas
        $transparentGif = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
        $html = preg_replace('/src=["\'](?!data:)[^"\']*imagenes\/[^"\']*["\']/i', 'src="' . $transparentGif . '"', $html);
        $html = preg_replace('/src=["\'](?!data:)[^"\']*:2808[0-9][^"\']*["\']/i', 'src="' . $transparentGif . '"', $html);

        // 8. Remover scripts no deseados como analíticas antiguas bloqueadas por CSP o quitarFrame
        $html = preg_replace('/<script[^>]*>.*?quitarFrame.*?<\/script>/is', '', $html);
        $html = preg_replace('/<script[^>]*>.*?google-analytics.*?<\/script>/is', '', $html);
        $html = preg_replace('/<script[^>]*>.*?ga\.js.*?<\/script>/is', '', $html);
        $html = preg_replace('/<script[^>]*src=["\'][^"\']*(?:google-analytics|ga\.js|urchin)[^"\']*["\'][^>]*>.*?<\/script>/is', '', $html);

        return ['success' => true, 'html' => $html];
    }
}
