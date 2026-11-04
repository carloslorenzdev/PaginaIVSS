<?php

namespace App\Actions\Consultas;

use Illuminate\Support\Facades\Http;

class ConsultarPensionadoAction
{
    public function execute(array $data)
    {
        try {
            $response = Http::timeout(15)
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
                ->post('http://www.ivss.gob.ve:28080/Pensionado/PensionadoCTRL', [
                    'nacionalidad' => $data['nacionalidad'],
                    'cedula' => $data['cedula'],
                    'd1' => $data['d1'],
                    'm1' => $data['m1'],
                    'y1' => $data['y1'],
                    'boton' => 'Consultar',
                ]);

            $html = $response->body();
            // Convertir la codificación de ISO-8859-1 a UTF-8
            $html = mb_convert_encoding($html, 'UTF-8', 'ISO-8859-1');

            if (preg_match("/alert\(['\"](.*?)['\"]\)/i", $html, $matches)) {
                return ['success' => true, 'isHtml' => false, 'message' => $matches[1]];
            }

            if (str_contains($html, 'pensión asociada') || str_contains(strtolower($html), 'no tiene pensión')) {
                if (preg_match("/EL CIUDADANO:(.*?)no tiene Pensión Asociada/i", $html, $m)) {
                    return ['success' => true, 'isHtml' => false, 'message' => "EL CIUDADANO:" . $m[1] . "no tiene Pensión Asociada"];
                }
                return ['success' => true, 'isHtml' => false, 'message' => 'El ciudadano no tiene Pensión Asociada.'];
            }

            // 1. Eliminar cualquier etiqueta <base> previa que apunte a puertos internos inaccesibles
            $html = preg_replace('/<base[^>]*>/i', '', $html);

            // 2. Eliminar enlaces a hojas de estilo externas bloqueadas o inaccesibles
            $html = preg_replace('/<link[^>]*href=["\'][^"\']*estilo\.css[^"\']*["\'][^>]*>/i', '', $html);
            $html = preg_replace('/<link[^>]*href=["\'][^"\']*2808[0-9][^"\']*["\'][^>]*>/i', '', $html);

            // 3. Encabezado institucional oficial en Base64 (superior.jpg)
            $superiorFile = public_path('imagenes/superior.jpg');
            if (!file_exists($superiorFile)) {
                $superiorFile = public_path('imagenes/cintillo-ivss.jpg');
            }
            $superiorBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($superiorFile));
            $html = preg_replace('/src=["\'][^"\']*superior\.jpg[^"\']*["\']/i', 'src="' . $superiorBase64 . '"', $html);

            // 4. Líneas divisorias decorativas en Base64 (bg_lineas.jpg, bg_lineas_med.jpg)
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

            // 5. Inyectar estilos CSS y fondo oficial idéntico al de la página de inicio (con Base64)
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
";
            if (stripos($html, '</head>') !== false) {
                $html = str_ireplace('</head>', $customCss . "\n</head>", $html);
            } else {
                $html = $customCss . "\n" . $html;
            }
            $html = preg_replace('/<body([^>]*)\s+background=["\'][^"\']*["\']/i', '<body$1', $html);

            // 6. Reemplazar cualquier imagen restante huérfana para evitar timeouts o peticiones directas
            $transparentGif = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
            $html = preg_replace('/src=["\'](?!data:)[^"\']*imagenes\/[^"\']*["\']/i', 'src="' . $transparentGif . '"', $html);
            $html = preg_replace('/src=["\'](?!data:)[^"\']*:2808[0-9][^"\']*["\']/i', 'src="' . $transparentGif . '"', $html);

            // 7. Remover scripts no deseados como quitarFrame o analíticas antiguas bloqueadas por CSP
            $html = preg_replace('/<script[^>]*>.*?quitarFrame.*?<\/script>/is', '', $html);
            $html = preg_replace('/<script[^>]*>.*?google-analytics.*?<\/script>/is', '', $html);
            $html = preg_replace('/<script[^>]*>.*?ga\.js.*?<\/script>/is', '', $html);
            $html = preg_replace('/<script[^>]*src=["\'][^"\']*(?:google-analytics|ga\.js|urchin)[^"\']*["\'][^>]*>.*?<\/script>/is', '', $html);

            return ['success' => true, 'isHtml' => true, 'html' => $html];

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error en consulta de pensionado: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return ['success' => false, 'isHtml' => false, 'message' => 'No fue posible establecer conexión con el sistema de consultas en este momento. Por favor intente más tarde.'];
        }
    }
}
