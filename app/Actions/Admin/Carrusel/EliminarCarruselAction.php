<?php

namespace App\Actions\Admin\Carrusel;

use App\Models\Carrusel;
use Illuminate\Support\Facades\Storage;

class EliminarCarruselAction
{
    public function execute($id)
    {
        $carrusel = Carrusel::findOrFail($id);
        
        if (!str_contains($carrusel->imagen_ruta, '..')) {
            Storage::disk('public')->delete($carrusel->imagen_ruta);
        }
        
        $carrusel->delete();

        return true;
    }
}
