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
                return ['success' => true, 'message' => $matches[1]];
            }

            if (str_contains($html, 'pensión asociada') || str_contains(strtolower($html), 'no tiene pensión')) {
                if (preg_match("/EL CIUDADANO:(.*?)no tiene Pensión Asociada/i", $html, $m)) {
                    return ['success' => true, 'message' => "EL CIUDADANO:" . $m[1] . "no tiene Pensión Asociada"];
                }
                return ['success' => true, 'message' => 'El ciudadano no tiene Pensión Asociada.'];
            }

            return ['success' => true, 'message' => 'Consulta procesada. Por favor verifique sus datos directamente en el portal del IVSS si no recibe el resultado esperado.'];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error de conexión con el servidor del IVSS. Detalles: ' . $e->getMessage()];
        }
    }
}
