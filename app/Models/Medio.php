<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Medio extends Model
{
    use HasFactory;

    protected $table   = 'medios';
    public $timestamps = false;

    protected $fillable = [
        'tipo',
        'nombre_original',
        'nombre_archivo',
        'ruta',
        'mime_type',
        'tamano',
        'ancho',
        'alto',
        'duracion',
        'leyenda',
        'credito',
        'usuario_id',
    ];

    protected $casts = [
        'tamano'      => 'integer',
        'ancho'       => 'integer',
        'alto'        => 'integer',
        'duracion'    => 'integer',
        'fecha_subida' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function noticias(): BelongsToMany
    {
        return $this->belongsToMany(Noticia::class, 'noticias_medios', 'medio_id', 'noticia_id')
            ->withPivot(['tipo_relacion', 'orden'])
            ->withTimestamps();
    }

    public function galerias(): BelongsToMany
    {
        return $this->belongsToMany(Galeria::class, 'galerias_medios', 'medio_id', 'galeria_id')
            ->withPivot(['orden'])
            ->withTimestamps();
    }
}
