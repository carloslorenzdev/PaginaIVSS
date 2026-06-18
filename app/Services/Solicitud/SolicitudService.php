<?php

namespace App\Services\Solicitud;

use App\Enums\EstatusSolicitudEnum;
use App\Interfaces\OldFiles;
use App\Models\Solicitudes\Solicitud;
use Atomescrochus\StringSimilarities\Compare;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Facades\Pdf;

class SolicitudService implements OldFiles
{
    /**
     * Directorio para guardar los pdfs
     */
    public const DIRECTORIO_PDF = 'solicitudes';

    /**
     * Genera numero de solicitud
     */
    public static function nuevoNumeroSolicitud()
    {
        return DB::connection('oracle_consulta')->table('dual')
            ->selectRaw('security.crear_nro_solicitud as numero')->first()?->numero;
    }

    /**
     * Genera numero de solicitud
     */
    public static function nuevoNumeroPatronal()
    {
        return DB::connection('oracle_consulta')->table('dual')
            ->selectRaw('security.crear_nro_patronal as numero')->first()?->numero;
    }

    /**
     * Valida si los datos nuevos coinciden con una solicitud pendiente o aprobada existente
     */
    public static function coincidenciaSolicitudes(array $data, ?int $idIgnore = null): string|null
    {
        $mensaje = null;

        $solicitudes = Solicitud::with([
            'parroquiaComercial' => [
                'municipio' => ['estado']
            ]
        ])->pendienteAprobada()->where('rif', Str::upper($data['tipo_rif'] . Str::padLeft($data['rif'], 9, '0')));

        if ($idIgnore) {
            $solicitudes->whereNot('id', $idIgnore);
        }

        $solicitudes = $solicitudes->get();

        if ($solicitudes->count()) {
            // PORCENTAJE MINIMO PARA CONSIDERAR IGUALES
            $minimaSimilitud = 90;
            // PORCENTAJE COINCIDENCIA MAS CERCANA
            $porcentajeMayor = 0;
            $estatusSolicitud = null;
            $solicitudSimilar = [];

            // RELACION DE CAMPOS
            $campos = [
                'av_calle_dc' => 'av_calle_dc',
                'edif_casa_dc' => 'edif_casa_dc',
                'piso_nivel_dc' => 'piso_nivel_dc',
                'apto_oficina_dc' => 'apto_oficina_dc',
                // 'pto_ref_dc' => 'pto_ref_dc',
                'cod_postal_dc' => 'cod_postal_dc',
            ];
            // VALIDACION DE CAMPOS
            foreach ($solicitudes as $solicitud) {
                $porcentajeAcumulado = 0;
                if ($data['parroquia_dc'] == $solicitud->fk_parroquia_dc) {
                    foreach ($campos as $campoBD => $campoForm) {
                        if (empty($data[$campoForm]) && empty($solicitud->{$campoBD})) {
                            $porcentaje = 100.0; // Ambas vacías, consideradas 100% similares
                        } else if (empty($data[$campoForm]) || empty($solicitud->{$campoBD})) {
                            $porcentaje = 0.0; // Una vacía y la otra no, consideradas 0% similares
                        } else {
                            // similar_text(strtoupper($data[$campoForm]), strtoupper($solicitud->{$campoBD}), $porcentaje);
                            $porcentaje = (new Compare)->jaroWinkler(strtoupper($data[$campoForm]), strtoupper($solicitud->{$campoBD}));
                            $porcentaje *= 100;
                        }
                        $solicitudSimilar[$campoBD] = $porcentaje;
                        $porcentajeAcumulado += $porcentaje;
                    }
                }
                // REDONDEA
                $porcentajeAcumulado = round($porcentajeAcumulado / count($campos), 2, PHP_ROUND_HALF_UP);
                if ($porcentajeAcumulado > $porcentajeMayor) {
                    // SOLICITUD MAS SIMILAR
                    $solicitudSimilar['id'] = $solicitud->id;
                    $porcentajeMayor = $porcentajeAcumulado;
                    $estatusSolicitud = $solicitud->estatus;
                }
            }
            info('porcentaje similitud mas cercana: ' . $porcentajeMayor . '%', [
                'porcentaje' => $porcentajeMayor,
                'solicitud' => $solicitudSimilar
            ]);
            if ($porcentajeMayor >= $minimaSimilitud) {
                // HAY SIMILITUD
                $mensaje = 'Exsiste una solicitud con esta dirección y RIF.';
                if ($estatusSolicitud == EstatusSolicitudEnum::PENDIENTE) {
                    $mensaje .= ' En caso que tenga estatus PENDIENTE debe esperar a que esta EXPIRE para generar una nueva.';
                } else {
                    $mensaje .= ' Si cree que esto es un error, por favor acérquese a una de nuestras Oficinas Administrativas para obtener más información y asistencia.';
                }
            }
        }
        return $mensaje;
    }

    /**
     * Genera PDF de la solicitud
     */
    public static function generaPDF(Solicitud $solicitud, ?bool $otro = false): string
    {
        $nombre = $solicitud->no_solicitud . '.pdf';
        $path = Str::finish(self::DIRECTORIO_PDF, '/') . $nombre;
        // GENERA PDF
        $solicitud->loadMissing([
            'oficinaIvss',
            'procesadoPor',
            'tipoEmpresa',
            'tipoSociedad',
            'tipoActividad',
            'parroquiaFiscal' => ['municipio' => ['estado']],
        ]);
        if ($otro) {
            $image = base64_encode(file_get_contents(public_path('imagenes/ivss_logo_rojo.png')));
            Pdf::view('solicitudes.pdf-propuesta', compact('solicitud'))
                ->format(Format::Letter)
                ->headerView('solicitudes.pdf-propuesta.header', compact('image'))
                ->footerView('solicitudes.pdf-propuesta.footer', compact('solicitud'))
                ->margins(100, 20, 70, 20, Unit::Pixel)
                ->withBrowsershot(function (Browsershot $browsershot) {
                    $browsershot->noSandbox()
                        ->writeOptionsToFile()
                        ->ignoreHttpsErrors()
                        ->waitUntilNetworkIdle()
                        ->emulateMedia('screen')
                        ->setIncludePath('$PATH:/usr/bin/');
                    if (in_array(PHP_OS_FAMILY, ['Linux', 'macOS'])) {
                        $browsershot->setChromePath('/usr/bin/chrome');
                    }
                })
                ->disk('local')->save($path);
        } else {
            Pdf::view('solicitudes.pdf', compact('solicitud'))
                ->format(Format::Letter)
                ->withBrowsershot(function (Browsershot $browsershot) {
                    $browsershot->noSandbox()
                        ->writeOptionsToFile()
                        ->ignoreHttpsErrors()
                        ->waitUntilNetworkIdle()
                        ->emulateMedia('screen')
                        ->setIncludePath('$PATH:/usr/bin/');
                    if (in_array(PHP_OS_FAMILY, ['Linux', 'macOS'])) {
                        $browsershot->setChromePath('/usr/bin/chrome');
                    }
                })
                ->disk('local')->save($path);
        }
        return $path;
    }

    /**
     * Lista archivos pdf antiguos
     */
    public static function archivosAntiguos(): array
    {
        $limiteDias = 3;
        $archivos = [];
        foreach (Storage::allFiles(self::DIRECTORIO_PDF) as $archivo) {
            if (Str::endsWith('.pdf', $archivo)) {
                if (now()->parse(Storage::lastModified($archivo))->diffInDays() > $limiteDias) {
                    $archivos[] = $archivo;
                }
            }
        }
        return $archivos;
    }
}
