<?php

namespace App\Actions\Publico;

use App\Models\Carrusel;
use App\Models\Noticia;
use App\Models\Configuracion;
use App\Models\ActividadAnual;
use Illuminate\Support\Facades\Schema;

class ObtenerInicioDataAction
{
    public function execute($previewCarousel = null, $previewSection3Bg = null, $previewSection3Text = null)
    {
        $carruseles = Carrusel::where(function($query) {
            $query->whereNull('fecha_publicacion')
                  ->orWhere('fecha_publicacion', '<=', now());
        })->orderBy('orden')->get();

        $noticias = Noticia::with(['medios' => function($query) {
            $query->where('noticias_medios.tipo_relacion', 'principal');
        }])->where('publicado', true)
          ->where('fecha_publicacion', '<=', now())
          ->orderBy('fecha_publicacion', 'desc')->take(3)->get();

        $configuraciones = Configuracion::pluck('valor', 'clave')->toArray();

        if ($previewCarousel) {
            $configuraciones['carrusel_estilo'] = $previewCarousel;
        }
        if ($previewSection3Bg) {
            $configuraciones['section3_bg_color'] = $previewSection3Bg;
        }
        if ($previewSection3Text) {
            $configuraciones['section3_text'] = $previewSection3Text;
        }

        $actividades = collect();
        try {
            if (Schema::hasTable('actividades_anuales')) {
                $actividades = ActividadAnual::with('medios')->where('activa', true)->latest()->get();
            }
        } catch (\Exception $e) {
            // Ignore exception if table doesn't exist
        }

        return compact('carruseles', 'noticias', 'configuraciones', 'actividades');
    }
}
