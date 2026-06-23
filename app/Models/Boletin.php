<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Boletin extends Model
{
    use HasFactory;

    protected $table = 'boletines';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_publicacion',
        'archivo_pdf',
        'imagen_preview',
        'publicado',
    ];

    protected $casts = [
        'fecha_publicacion' => 'date',
        'publicado' => 'boolean',
    ];
}
