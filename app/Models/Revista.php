<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revista extends Model
{
    protected $table = 'revistas';

    protected $fillable = [
        'titulo',
        'edicion',
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
