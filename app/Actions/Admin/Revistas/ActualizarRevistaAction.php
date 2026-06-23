<?php

namespace App\Actions\Admin\Revistas;

use App\Models\Revista;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActualizarRevistaAction
{
    public function execute(Revista $revista, array $data)
    {
        if (isset($data['archivo_pdf'])) {
            // Eliminar el PDF anterior
            if ($revista->archivo_pdf && Storage::disk('public')->exists($revista->archivo_pdf)) {
                Storage::disk('public')->delete($revista->archivo_pdf);
            }
            // Eliminar imagen anterior
            if ($revista->imagen_preview && Storage::disk('public')->exists($revista->imagen_preview)) {
                Storage::disk('public')->delete($revista->imagen_preview);
            }

            $pdfPath = $data['archivo_pdf']->store('revistas/pdfs', 'public');
            $revista->archivo_pdf = $pdfPath;
            $absolutePdfPath = Storage::disk('public')->path($pdfPath);

            // Extraer Texto
            try {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($absolutePdfPath);
                $text = $pdf->getText();
                $text = trim(preg_replace('/\s+/', ' ', $text));
                if (strlen($text) > 20) {
                    $revista->descripcion = Str::limit($text, 250);
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
                        $imageName = 'revistas/imagenes/' . Str::random(40) . '.' . $imageType;
                        Storage::disk('public')->put($imageName, $imageBase64);
                        $revista->imagen_preview = $imageName;
                    }
                } catch (\Throwable $e) {}
            } else {
                try {
                    $imageNameRaw = Str::random(40) . '.jpg';
                    $imageName = 'revistas/imagenes/' . $imageNameRaw;
                    $absoluteImagePath = Storage::disk('public')->path($imageName);
                    
                    if (!Storage::disk('public')->exists('revistas/imagenes')) {
                        Storage::disk('public')->makeDirectory('revistas/imagenes');
                    }

                    $pdfToImage = new \Spatie\PdfToImage\Pdf($absolutePdfPath);
                    $pdfToImage->saveImage($absoluteImagePath);
                    $revista->imagen_preview = $imageName;
                } catch (\Throwable $e) {
                    $revista->imagen_preview = null;
                }
            }
        }

        $revista->titulo = $data['titulo'];
        $revista->edicion = $data['edicion'] ?? null;
        $revista->fecha_publicacion = $data['fecha_publicacion'];
        $revista->save();

        return $revista;
    }
}
