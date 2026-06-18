<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Noticia extends Model
{
    use HasFactory;

    protected $table = 'noticias';

    protected $fillable = [
        'titulo',
        'slug',
        'contenido',
        'resumen',
        'categoria_id', // deprecated pero se mantiene por compatibilidad
        'autor_id',
        'publicado',
        'fecha_publicacion',
        'enlace_externo',
        'etiquetas',
        'creditos_autor',
    ];

    protected $casts = [
        'publicado'           => 'boolean',
        'fecha_publicacion'   => 'datetime',
        'created_at'          => 'datetime',
        'updated_at'          => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    /** Relación deprecada 1:M (compatibilidad) */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /** Relación M:M actual */
    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(Categoria::class, 'categoria_noticia', 'noticia_id', 'categoria_id')
            ->withTimestamps('created_at', 'updated_at');
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function medios(): BelongsToMany
    {
        return $this->belongsToMany(Medio::class, 'noticias_medios', 'noticia_id', 'medio_id')
            ->withPivot(['tipo_relacion', 'orden']);
    }
}
