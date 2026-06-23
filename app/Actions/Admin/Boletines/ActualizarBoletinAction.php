<?php

namespace App\Actions\Admin\Boletines;

use App\Models\Boletin;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActualizarBoletinAction
{
    public function execute(Boletin $boletin, array $data)
    {
        if (isset($data['archivo_pdf'])) {
            // Eliminar el PDF anterior
            if ($boletin->archivo_pdf && Storage::disk('public')->exists($boletin->archivo_pdf)) {
                Storage::disk('public')->delete($boletin->archivo_pdf);
            }
            // Eliminar imagen anterior
            if ($boletin->imagen_preview && Storage::disk('public')->exists($boletin->imagen_preview)) {
                Storage::disk('public')->delete($boletin->imagen_preview);
            }

            $pdfPath = $data['archivo_pdf']->store('boletines/pdfs', 'public');
            $boletin->archivo_pdf = $pdfPath;
            $absolutePdfPath = Storage::disk('public')->path($pdfPath);

            // Extraer Texto
            try {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($absolutePdfPath);
                $text = $pdf->getText();
                $text = trim(preg_replace('/\s+/', ' ', $text));
                if (strlen($text) > 20) {
                    $boletin->descripcion = Str::limit($text, 250);
                }
            } catch (\Throwable $e) {}

            // Extraer Imagen
            if (!empty($data['imagen_base64'])) {
                try {
                    $imagenBase64 = $data['imagen_base64'];
                    $imageParts = explode(";base64,", $imagenBase64);
                    if(count($imageParts) == 2) {
                        $imageTypeAux = explode("image/", $imageParts[0]);
                        $imageType = $imageTypeAux[1];
                        $imageBase64 = base64_decode($imageParts[1]);
                        $imageName = 'boletines/imagenes/' . Str::random(40) . '.' . $imageType;
                        Storage::disk('public')->put($imageName, $imageBase64);
                        $boletin->imagen_preview = $imageName;
                    }
                } catch (\Throwable $e) {}
            } else {
                try {
                    $imageNameRaw = Str::random(40) . '.jpg';
                    $imageName = 'boletines/imagenes/' . $imageNameRaw;
                    $absoluteImagePath = Storage::disk('public')->path($imageName);
                    
                    if (!Storage::disk('public')->exists('boletines/imagenes')) {
                        Storage::disk('public')->makeDirectory('boletines/imagenes');
                    }

                    $pdfToImage = new \Spatie\PdfToImage\Pdf($absolutePdfPath);
                    $pdfToImage->saveImage($absoluteImagePath);
                    $boletin->imagen_preview = $imageName;
                } catch (\Throwable $e) {
                    $boletin->imagen_preview = null;
                }
            }
        }

        $boletin->titulo = $data['titulo'];
        $boletin->fecha_publicacion = $data['fecha_publicacion'];
        $boletin->save();

        return $boletin;
    }
}
