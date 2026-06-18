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
}
