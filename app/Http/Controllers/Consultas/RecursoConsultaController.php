<?php

namespace App\Http\Controllers\Consultas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class RecursoConsultaController extends Controller
{
    /**
     * Proxy y caché de recursos estáticos (imágenes y CSS) para las consultas
     * de Pensionados y Cuenta Individual. Evita timeouts y errores de CSP
     * al no exponer los puertos internos 28080/28083 al navegador del cliente.
     */
    public function obtener(Request $request, string $servicio, string $archivo)
    {
        // Limpiar la ruta del archivo para evitar Directory Traversal (CWE-22)
        $archivoLimpio = ltrim(str_replace(['../', '..\\'], '', $archivo), '/');
        $extension = strtolower(pathinfo($archivoLimpio, PATHINFO_EXTENSION));
        $nombreBase = basename($archivoLimpio);

        // Mapear tipos MIME
        $mimeTypes = [
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'css'  => 'text/css',
            'svg'  => 'image/svg+xml',
        ];
        $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

        // Directorio de almacenamiento en caché
        $cacheDir = storage_path('app/consultas_cache/' . $servicio);
        if (!File::isDirectory($cacheDir)) {
            File::makeDirectory($cacheDir, 0755, true, true);
        }
        $cachePath = $cacheDir . '/' . md5($archivoLimpio) . '.' . $extension;

        // Si ya está en caché y tiene contenido, servirlo directamente
        if (File::exists($cachePath) && File::size($cachePath) > 0) {
            return response(File::get($cachePath), 200, [
                'Content-Type' => $contentType,
                'Cache-Control' => 'public, max-age=604800, immutable',
            ]);
        }

        // Determinar URL del backend interno
        $urlBackend = null;
        if ($servicio === 'pensionado') {
            $urlBackend = 'http://www.ivss.gob.ve:28080/Pensionado/' . $archivoLimpio;
        } elseif ($servicio === 'cuenta') {
            $urlBackend = 'http://www.ivss.gob.ve:28083/CuentaIndividualIntranet/' . $archivoLimpio;
        }

        if ($urlBackend) {
            try {
                $response = Http::timeout(3)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 IVSS-Proxy'])
                    ->get($urlBackend);

                if ($response->successful() && strlen($response->body()) > 0) {
                    File::put($cachePath, $response->body());
                    return response($response->body(), 200, [
                        'Content-Type' => $response->header('Content-Type') ?: $contentType,
                        'Cache-Control' => 'public, max-age=604800, immutable',
                    ]);
                }
            } catch (\Exception $e) {
                // Si la conexión interna falla o hace timeout, usar respaldo local
            }
        }

        // --- RESPALDOS LOCALES ---
        // 1. Cabezal institucional (superior.jpg / superior2.png)
        if (str_contains(strtolower($nombreBase), 'superior')) {
            $localHeader = public_path('imagenes/cintillo-ivss.jpg');
            if (File::exists($localHeader)) {
                return response(File::get($localHeader), 200, [
                    'Content-Type' => 'image/jpeg',
                    'Cache-Control' => 'public, max-age=86400',
                ]);
            }
            $localHeaderPng = public_path('imagenes/cintillo ivss_2026.png');
            if (File::exists($localHeaderPng)) {
                return response(File::get($localHeaderPng), 200, [
                    'Content-Type' => 'image/png',
                    'Cache-Control' => 'public, max-age=86400',
                ]);
            }
        }

        // 2. Marca de agua o logo institucional (marcaivss01.JPG)
        if (str_contains(strtolower($nombreBase), 'marcaivss')) {
            $localLogo = public_path('imagenes/fondo-ivss.png');
            if (File::exists($localLogo)) {
                return response(File::get($localLogo), 200, [
                    'Content-Type' => 'image/png',
                    'Cache-Control' => 'public, max-age=86400',
                ]);
            }
        }

        // 3. Estilos CSS (estilo.css)
        if ($extension === 'css') {
            $cssDefault = "
                body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
                table { border-collapse: collapse; margin: 0 auto; width: 95%; max-width: 900px; background-color: #ffffff; }
                th, td { border: 1px solid #336699; padding: 6px 10px; font-size: 12px; }
                th { background-color: #336699; color: #ffffff; text-align: center; }
                .titulo, h2, h3, h4 { color: #003366; text-align: center; font-weight: bold; }
                .text-center { text-align: center; }
                .text-bold { font-weight: bold; }
            ";
            return response($cssDefault, 200, [
                'Content-Type' => 'text/css',
                'Cache-Control' => 'public, max-age=86400',
            ]);
        }

        // 4. Fondos de líneas transparentes (bg_lineas.jpg, bg_lineas_med.jpg)
        // Imagen PNG transparente de 1x1 px en base64
        $pixelTransparente = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=');
        return response($pixelTransparente, 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}

