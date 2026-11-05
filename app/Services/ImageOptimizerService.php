<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ImageOptimizerService
{
    /**
     * Calidad WebP predeterminada (82 es el estándar óptimo calidad/peso de Google).
     */
    public const CALIDAD_WEBP = 82;

    /**
     * Ancho máximo estándar para banners, carruseles y fondos panorámicos.
     */
    public const MAX_WIDTH_BANNER = 1920;

    /**
     * Ancho máximo estándar para fotografías de noticias, galerías y artículos.
     */
    public const MAX_WIDTH_NOTICIA = 1400;

    /**
     * Optimiza y convierte una imagen entrante (upload) a formato WebP.
     * Si no es una imagen raster compatible o falla GD, recurre a guardado tradicional sin interrumpir el flujo.
     *
     * @param mixed $archivo UploadedFile, Livewire TemporaryUploadedFile o string de ruta
     * @param string $carpeta Directorio dentro del disco (ej: 'medios', 'carrusel', 'banners', 'modulos')
     * @param string|null $nombreBase Nombre deseado sin extensión (opcional)
     * @param int|null $maxWidth Ancho máximo permitido (escala proporcionalmente)
     * @param int $calidad Calidad de compresión WebP (1-100)
     * @param string $disk Disco de Storage de Laravel (default: 'public')
     * @return array [ruta, nombre_archivo, mime_type, tamano]
     */
    public static function optimizarYGuardar(
        $archivo,
        string $carpeta,
        ?string $nombreBase = null,
        ?int $maxWidth = self::MAX_WIDTH_BANNER,
        int $calidad = self::CALIDAD_WEBP,
        string $disk = 'public'
    ): array {
        @ini_set('memory_limit', '256M');

        $rutaReal = self::obtenerRutaReal($archivo);
        $nombreOriginal = self::obtenerNombreOriginal($archivo);

        if (!$nombreBase) {
            $nombreOriginalSinExt = pathinfo($nombreOriginal, PATHINFO_FILENAME);
            $nombreBase = time() . '-' . Str::slug($nombreOriginalSinExt);
        }

        // Si GD no tiene soporte WebP o el archivo no existe, guardar normal
        if (!function_exists('imagewebp') || !$rutaReal || !file_exists($rutaReal)) {
            return self::guardarFallback($archivo, $carpeta, $nombreBase, $disk);
        }

        $mimeType = self::detectarMimeType($rutaReal);

        // Si no es un formato raster convertible (ej. SVG o documento), guardar tal cual
        if (!in_array($mimeType, ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'])) {
            return self::guardarFallback($archivo, $carpeta, $nombreBase, $disk);
        }

        try {
            $img = self::crearRecursoGD($rutaReal, $mimeType);

            if (!$img) {
                return self::guardarFallback($archivo, $carpeta, $nombreBase, $disk);
            }

            // Corregir orientación EXIF para fotos de cámaras/teléfonos (JPEG)
            if ($mimeType === 'image/jpeg' || $mimeType === 'image/jpg') {
                $img = self::corregirOrientacionExif($img, $rutaReal);
            }

            // Preservar canal alfa (transparencia) para PNG/GIF/WEBP
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);

            // Redimensionar proporcionalmente si supera el ancho máximo
            $anchoOrig = imagesx($img);
            $altoOrig = imagesy($img);

            if ($maxWidth && $anchoOrig > $maxWidth) {
                $nuevoAncho = $maxWidth;
                $nuevoAlto = (int) round(($altoOrig / $anchoOrig) * $nuevoAncho);
                $redimensionado = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                imagealphablending($redimensionado, false);
                imagesavealpha($redimensionado, true);

                imagecopyresampled($redimensionado, $img, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $anchoOrig, $altoOrig);
                imagedestroy($img);
                $img = $redimensionado;
            }

            // Exportar a WebP en archivo temporal
            $tempWebp = tempnam(sys_get_temp_dir(), 'webp_');
            imagewebp($img, $tempWebp, $calidad);
            imagedestroy($img);

            $nombreArchivo = $nombreBase . '.webp';
            $rutaRelativa = trim($carpeta, '/') . '/' . $nombreArchivo;

            $contenido = file_get_contents($tempWebp);
            $tamano = filesize($tempWebp);
            @unlink($tempWebp);

            Storage::disk($disk)->put($rutaRelativa, $contenido);

            return [
                'ruta' => $rutaRelativa,
                'nombre_archivo' => $nombreArchivo,
                'mime_type' => 'image/webp',
                'tamano' => $tamano,
            ];
        } catch (\Throwable $e) {
            Log::warning("Fallo en optimización WebP, aplicando fallback normal: " . $e->getMessage());
            return self::guardarFallback($archivo, $carpeta, $nombreBase, $disk);
        }
    }

    /**
     * Convierte un archivo de imagen ya existente en el Storage a formato WebP.
     * Retorna la nueva ruta relativa en el disco, o null si falla.
     */
    public static function convertirArchivoExistenteAWebp(
        string $rutaRelativaStorage,
        ?int $maxWidth = self::MAX_WIDTH_BANNER,
        int $calidad = self::CALIDAD_WEBP,
        string $disk = 'public',
        bool $eliminarOriginal = true
    ): ?string {
        @ini_set('memory_limit', '256M');

        if (!Storage::disk($disk)->exists($rutaRelativaStorage)) {
            return null;
        }

        $rutaAbsoluta = Storage::disk($disk)->path($rutaRelativaStorage);
        $extension = strtolower(pathinfo($rutaAbsoluta, PATHINFO_EXTENSION));

        // Si ya es webp, verificar si necesita redimensionarse
        if ($extension === 'webp') {
            return $rutaRelativaStorage;
        }

        $mimeType = self::detectarMimeType($rutaAbsoluta);
        if (!in_array($mimeType, ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
            return null;
        }

        try {
            $img = self::crearRecursoGD($rutaAbsoluta, $mimeType);
            if (!$img) return null;

            if ($mimeType === 'image/jpeg' || $mimeType === 'image/jpg') {
                $img = self::corregirOrientacionExif($img, $rutaAbsoluta);
            }

            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);

            $anchoOrig = imagesx($img);
            $altoOrig = imagesy($img);

            if ($maxWidth && $anchoOrig > $maxWidth) {
                $nuevoAncho = $maxWidth;
                $nuevoAlto = (int) round(($altoOrig / $anchoOrig) * $nuevoAncho);
                $redimensionado = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                imagealphablending($redimensionado, false);
                imagesavealpha($redimensionado, true);

                imagecopyresampled($redimensionado, $img, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $anchoOrig, $altoOrig);
                imagedestroy($img);
                $img = $redimensionado;
            }

            $dirRelativo = pathinfo($rutaRelativaStorage, PATHINFO_DIRNAME);
            $filenameSinExt = pathinfo($rutaRelativaStorage, PATHINFO_FILENAME);
            $nuevaRutaRelativa = ($dirRelativo === '.' ? '' : $dirRelativo . '/') . $filenameSinExt . '.webp';
            $nuevaRutaAbsoluta = Storage::disk($disk)->path($nuevaRutaRelativa);

            imagewebp($img, $nuevaRutaAbsoluta, $calidad);
            imagedestroy($img);

            if ($eliminarOriginal && $rutaRelativaStorage !== $nuevaRutaRelativa) {
                Storage::disk($disk)->delete($rutaRelativaStorage);
            }

            return $nuevaRutaRelativa;
        } catch (\Throwable $e) {
            Log::warning("Fallo al convertir archivo existente a WebP ({$rutaRelativaStorage}): " . $e->getMessage());
            return null;
        }
    }

    /**
     * Convierte un archivo estático en public/ (ej: cintillo o fondos) a WebP.
     */
    public static function optimizarArchivoEstatico(
        string $rutaAbsoluta,
        ?string $destinoWebp = null,
        ?int $maxWidth = self::MAX_WIDTH_BANNER,
        int $calidad = self::CALIDAD_WEBP
    ): ?string {
        if (!file_exists($rutaAbsoluta)) return null;

        $mimeType = self::detectarMimeType($rutaAbsoluta);
        if (!in_array($mimeType, ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
            return null;
        }

        try {
            $img = self::crearRecursoGD($rutaAbsoluta, $mimeType);
            if (!$img) return null;

            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);

            $anchoOrig = imagesx($img);
            $altoOrig = imagesy($img);

            if ($maxWidth && $anchoOrig > $maxWidth) {
                $nuevoAncho = $maxWidth;
                $nuevoAlto = (int) round(($altoOrig / $anchoOrig) * $nuevoAncho);
                $redimensionado = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                imagealphablending($redimensionado, false);
                imagesavealpha($redimensionado, true);

                imagecopyresampled($redimensionado, $img, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $anchoOrig, $altoOrig);
                imagedestroy($img);
                $img = $redimensionado;
            }

            if (!$destinoWebp) {
                $dir = pathinfo($rutaAbsoluta, PATHINFO_DIRNAME);
                $name = pathinfo($rutaAbsoluta, PATHINFO_FILENAME);
                $destinoWebp = $dir . DIRECTORY_SEPARATOR . $name . '.webp';
            }

            imagewebp($img, $destinoWebp, $calidad);
            imagedestroy($img);

            return $destinoWebp;
        } catch (\Throwable $e) {
            Log::warning("Error optimizando archivo estático a WebP ({$rutaAbsoluta}): " . $e->getMessage());
            return null;
        }
    }

    /**
     * Crea un recurso GD a partir de la ruta y su MIME type.
     */
    protected static function crearRecursoGD(string $ruta, string $mimeType)
    {
        return match ($mimeType) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($ruta),
            'image/png' => @imagecreatefrompng($ruta),
            'image/webp' => @imagecreatefromwebp($ruta),
            'image/gif' => @imagecreatefromgif($ruta),
            default => null,
        };
    }

    /**
     * Corrige la rotación según metadatos EXIF.
     */
    protected static function corregirOrientacionExif($img, string $ruta)
    {
        if (!function_exists('exif_read_data')) {
            return $img;
        }

        try {
            $exif = @exif_read_data($ruta);
            if (!empty($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 3:
                        $rotated = imagerotate($img, 180, 0);
                        imagedestroy($img);
                        return $rotated;
                    case 6:
                        $rotated = imagerotate($img, -90, 0);
                        imagedestroy($img);
                        return $rotated;
                    case 8:
                        $rotated = imagerotate($img, 90, 0);
                        imagedestroy($img);
                        return $rotated;
                }
            }
        } catch (\Throwable) {
            // Silencioso ante fallos al leer EXIF
        }

        return $img;
    }

    /**
     * Obtiene la ruta física real del archivo independientemente del tipo de objeto.
     */
    protected static function obtenerRutaReal($archivo): ?string
    {
        if (is_string($archivo)) {
            return file_exists($archivo) ? $archivo : null;
        }

        if (is_object($archivo) && method_exists($archivo, 'getRealPath')) {
            return $archivo->getRealPath();
        }

        if (is_object($archivo) && method_exists($archivo, 'path')) {
            return $archivo->path();
        }

        return null;
    }

    /**
     * Obtiene el nombre original del archivo.
     */
    protected static function obtenerNombreOriginal($archivo): string
    {
        if (is_object($archivo) && method_exists($archivo, 'getClientOriginalName')) {
            return $archivo->getClientOriginalName();
        }

        if (is_string($archivo)) {
            return basename($archivo);
        }

        return 'imagen-' . time();
    }

    /**
     * Detecta el tipo MIME exacto a partir del archivo con finfo.
     */
    protected static function detectarMimeType(string $ruta): string
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        return $finfo->file($ruta) ?: 'application/octet-stream';
    }

    /**
     * Fallback de guardado estándar cuando no aplica WebP.
     */
    protected static function guardarFallback($archivo, string $carpeta, string $nombreBase, string $disk): array
    {
        if (is_object($archivo) && method_exists($archivo, 'storeAs')) {
            $extension = method_exists($archivo, 'extension') ? ($archivo->extension() ?: 'bin') : 'bin';
            $nombreArchivo = $nombreBase . '.' . $extension;
            $ruta = $archivo->storeAs($carpeta, $nombreArchivo, $disk);

            return [
                'ruta' => $ruta,
                'nombre_archivo' => $nombreArchivo,
                'mime_type' => method_exists($archivo, 'getMimeType') ? $archivo->getMimeType() : 'application/octet-stream',
                'tamano' => method_exists($archivo, 'getSize') ? $archivo->getSize() : 0,
            ];
        }

        return [
            'ruta' => '',
            'nombre_archivo' => '',
            'mime_type' => '',
            'tamano' => 0,
        ];
    }
}
