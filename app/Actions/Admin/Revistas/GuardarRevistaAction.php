<?php

namespace App\Actions\Admin\Revistas;

use App\Models\Revista;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GuardarRevistaAction
{
    public function execute(array $data)
    {
        $archivo_pdf = $data['archivo_pdf'];
        $pdfPath = $archivo_pdf->store('revistas/pdfs', 'public');
        $absolutePdfPath = Storage::disk('public')->path($pdfPath);
        
        // 1. Extraer Texto con PHP
        $descripcion = 'Revista Institucional del IVSS.';
        try {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($absolutePdfPath);
            $text = $pdf->getText();
            $text = trim(preg_replace('/\s+/', ' ', $text));
            if (strlen($text) > 20) {
                $descripcion = Str::limit($text, 250);
            }
        } catch (\Throwable $e) {
            // Fallback silencioso
        }

        // 2. Extraer Imagen
        $imageName = null;
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
            } catch (\Throwable $e) {
                $imageName = null;
            }
        }

        return Revista::create([
            'titulo' => $data['titulo'],
            'edicion' => $data['edicion'] ?? null,
            'descripcion' => $descripcion,
            'fecha_publicacion' => $data['fecha_publicacion'],
            'archivo_pdf' => $pdfPath,
            'imagen_preview' => $imageName,
            'publicado' => true,
        ]);
    }
}
