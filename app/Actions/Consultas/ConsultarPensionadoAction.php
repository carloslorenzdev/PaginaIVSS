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

            // Eliminar cualquier etiqueta <base> previa que apunte a puertos internos inaccesibles
            $html = preg_replace('/<base[^>]*>/i', '', $html);

            // Reemplazar referencias a recursos para que pasen por el proxy seguro de Laravel
            $html = str_ireplace('src="superior.jpg"', 'src="/consulta/recurso/pensionado/imagenes/superior.jpg"', $html);
            $html = str_ireplace("src='superior.jpg'", "src='/consulta/recurso/pensionado/imagenes/superior.jpg'", $html);
            $html = str_ireplace('src="imagenes/', 'src="/consulta/recurso/pensionado/imagenes/', $html);
            $html = str_ireplace("src='imagenes/", "src='/consulta/recurso/pensionado/imagenes/", $html);
            $html = str_ireplace('href="css/', 'href="/consulta/recurso/pensionado/css/', $html);
            $html = str_ireplace("href='css/", "href='/consulta/recurso/pensionado/css/", $html);

            // Inyectar el fondo oficial con marca de agua institucional del IVSS
            $fondoPath = public_path('imagenes/fondo-ivss.png');
            if (file_exists($fondoPath)) {
                $bgBase64 = base64_encode(file_get_contents($fondoPath));
                $bgStyle = "<style>
                    body {
                        background-image: url('data:image/png;base64,{$bgBase64}') !important;
                        background-repeat: repeat !important;
                        background-position: center top !important;
                        font-family: Arial, Helvetica, sans-serif !important;
                    }
                </style>";
                if (strpos($html, '</head>') !== false) {
                    $html = str_replace('</head>', $bgStyle . "\n</head>", $html);
                } else {
                    $html = $bgStyle . "\n" . $html;
                }
                $html = preg_replace('/<body([^>]*)\s+background=["\'][^"\']*["\']/i', '<body$1', $html);
            }

            // Remover scripts no deseados como quitarFrame o analíticas antiguas bloqueadas por CSP
            $html = preg_replace('/<script[^>]*>.*?quitarFrame.*?<\/script>/is', '', $html);
            $html = preg_replace('/<script[^>]*>.*?google-analytics.*?<\/script>/is', '', $html);
            $html = preg_replace('/<script[^>]*>.*?ga\.js.*?<\/script>/is', '', $html);

            return ['success' => true, 'isHtml' => true, 'html' => $html];

        } catch (\Exception $e) {
            return ['success' => false, 'isHtml' => false, 'message' => 'Error de conexión con el servidor del IVSS. Detalles: ' . $e->getMessage()];
        }
    }
}
