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

        // Eliminar cualquier etiqueta <base> previa que apunte a puertos internos inaccesibles
        $html = preg_replace('/<base[^>]*>/i', '', $html);

        // Reemplazar referencias a recursos para que pasen por el proxy seguro de Laravel
        $html = str_ireplace('src="superior2.png"', 'src="/consulta/recurso/cuenta/imagenes/superior2.png"', $html);
        $html = str_ireplace("src='superior2.png'", "src='/consulta/recurso/cuenta/imagenes/superior2.png'", $html);
        $html = str_ireplace('src="marcaivss01.JPG"', 'src="/consulta/recurso/cuenta/imagenes/marcaivss01.JPG"', $html);
        $html = str_ireplace("src='marcaivss01.JPG'", "src='/consulta/recurso/cuenta/imagenes/marcaivss01.JPG'", $html);
        $html = str_ireplace('src="imagenes/', 'src="/consulta/recurso/cuenta/imagenes/', $html);
        $html = str_ireplace("src='imagenes/", "src='/consulta/recurso/cuenta/imagenes/", $html);
        $html = str_ireplace('href="css/', 'href="/consulta/recurso/cuenta/css/', $html);
        $html = str_ireplace("href='css/", "href='/consulta/recurso/cuenta/css/", $html);

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

        // Remover scripts no deseados como analíticas antiguas bloqueadas por CSP o quitarFrame
        $html = preg_replace('/<script[^>]*>.*?quitarFrame.*?<\/script>/is', '', $html);
        $html = preg_replace('/<script[^>]*>.*?google-analytics.*?<\/script>/is', '', $html);
        $html = preg_replace('/<script[^>]*>.*?ga\.js.*?<\/script>/is', '', $html);

        return ['success' => true, 'html' => $html];
    }
}
