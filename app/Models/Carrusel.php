<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrusel extends Model
{
    use HasFactory;

    protected $table = 'carrusels';

    protected $fillable = [
        'imagen_ruta',
        'enlace',
        'orden',
        'titulo',
        'etiquetas',
        'detalles',
        'fecha_publicacion',
        'autor',
        'noticia_id',
    ];

    protected $casts = [
        'fecha_publicacion' => 'datetime',
    ];

    /**
     * Mantiene un máximo estricto de elementos en el carrusel (por defecto 10).
     * Si supera el límite, elimina los elementos más antiguos (al fondo del orden)
     * y reindexa consecutivamente del 1 al $max.
     */
    public static function limitarAMaximo(int $max = 10): void
    {
        $total = self::count();
        if ($total > $max) {
            $sobrantes = self::orderBy('orden', 'desc')
                ->take($total - $max)
                ->get();

            foreach ($sobrantes as $sobrante) {
                if ($sobrante->imagen_ruta && str_starts_with($sobrante->imagen_ruta, 'carrusel/')) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($sobrante->imagen_ruta);
                }
                $sobrante->delete();
            }

            $orden = 1;
            foreach (self::orderBy('orden', 'asc')->get() as $item) {
                $item->update(['orden' => $orden++]);
            }
        }
    }
}
