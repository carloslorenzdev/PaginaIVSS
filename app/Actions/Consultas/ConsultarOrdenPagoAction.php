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
                    'Origin' => 'http://autoliquidacionv2.ivss.gob.ve:28081',
                    'Referer' => 'http://autoliquidacionv2.ivss.gob.ve:28081/FacturaDigitalOnline/',
                    'Connection' => 'keep-alive',
                ])
                ->asForm()
                ->post('http://autoliquidacionv2.ivss.gob.ve:28081/FacturaDigitalOnline/', [
                    'IdEmpresa' => $data['IdEmpresa'],
                    'periodo' => $data['periodo'],
                    'tipoEmpresa' => $data['tipoEmpresa'],
                    'boton' => 'Probar Reporte'
                ]);

            return [
                'success' => true,
                'body' => $response->body(),
                'status' => $response->status(),
                'contentType' => $response->header('Content-Type') ?? 'text/html'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => "<h1>Error de conexión</h1><p>No se pudo conectar con el servidor del IVSS.</p><p>Detalles: " . $e->getMessage() . "</p>"
            ];
        }
    }
}
