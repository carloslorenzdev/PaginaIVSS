<?php

namespace App\Services\Sistema;

use App\Interfaces\OldFiles;
use App\Services\Solicitud\SolicitudService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ArchivosService
{
    /**
     * Clases de servicio a utilizar
     */
    public static function getHandleClasses(): array
    {
        return [
            SolicitudService::class,
        ];
    }

    /**
     * Elimina archivos antiguos segun tiempo de cada clase
     */
    public static function eliminarAntiguos()
    {
        $clases = self::getHandleClasses();
        foreach ($clases as $nombreClase) {
            $claseServicio = app($nombreClase);
            if ($claseServicio instanceof OldFiles) {
                $archivosEliminar = $claseServicio::archivosAntiguos();
                Storage::delete($archivosEliminar);
                Log::channel('job')->info('Eliminados ' . count($archivosEliminar) . ' archivos de ' . $nombreClase);
            }
        }
    }
}
