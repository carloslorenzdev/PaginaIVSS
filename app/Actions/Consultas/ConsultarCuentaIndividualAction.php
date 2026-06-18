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

        // Inject base URL so images and CSS load correctly from the new tab
        $baseTag = "<base href=\"{$baseUrl}\">";
        if (strpos($html, '<head>') !== false) {
            $html = str_replace('<head>', "<head>\n    " . $baseTag, $html);
        } else {
            $html = $baseTag . "\n" . $html;
        }
        
        return ['success' => true, 'html' => $html];
    }
}
