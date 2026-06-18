<?php

namespace App\Actions\Admin\Carrusel;

use App\Models\Carrusel;
use Illuminate\Support\Str;

class CrearCarruselAction
{
    public function execute(array $data, $archivo)
    {
        $extension = $archivo->getClientOriginalExtension();
        $nombreOriginalStr = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
        $nombreArchivo = time() . '-' . Str::slug($nombreOriginalStr) . '.' . $extension;
        $ruta = $archivo->storeAs('carrusel', $nombreArchivo, 'public');

        return Carrusel::create([
            'imagen_ruta' => $ruta,
            'enlace' => $data['enlace'] ?? null,
            'orden' => $data['orden'] ?? (Carrusel::max('orden') + 1),
            'titulo' => $data['titulo'] ?? null,
            'etiquetas' => $data['etiquetas'] ?? null,
            'fecha_publicacion' => $data['fecha_publicacion'] ?? null,
            'autor' => $data['autor'] ?? null,
        ]);
    }
}
