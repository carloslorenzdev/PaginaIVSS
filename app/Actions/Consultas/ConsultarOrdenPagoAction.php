<?php

namespace App\Actions\Consultas;

use Illuminate\Support\Facades\Http;

class ConsultarOrdenPagoAction
{
    public function execute(array $data)
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Origin' => 'http://www.ivss.gov.ve',
                    'Referer' => 'http://www.ivss.gov.ve/',
                    'Connection' => 'keep-alive',
                ])
                ->asForm()
                ->post('http://autoliquidacionv2.ivss.gob.ve:28081/FacturaDigitalOnline/BrowseReport', [
                    'idEmpresa' => $data['idEmpresa'],
                    'periodo' => $data['periodo'],
                    'tipoEmpresa' => $data['tipoEmpresa'],
                    'boton' => 'Consultar'
                ]);

            $body = $response->body();
            
            // Si el IVSS responde con un script de alerta o texto plano de error
            $bodyUtf8 = mb_convert_encoding($body, 'UTF-8', 'ISO-8859-1');
            if (strpos($bodyUtf8, 'alert(') !== false) {
                preg_match("/alert\(['\"](.*?)['\"]\)/", $bodyUtf8, $matches);
                $errorMsg = $matches[1] ?? 'No se encontró información o los datos son inválidos.';
                return [
                    'success' => false,
                    'message' => $errorMsg
                ];
            }

            // Si es un PDF, devolver el binario
            return [
                'success' => true,
                'body' => $body,
                'contentType' => 'application/pdf'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => "No se pudo conectar con el servidor del IVSS. Intente nuevamente."
            ];
        }
    }
}
