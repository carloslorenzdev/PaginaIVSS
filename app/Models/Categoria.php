<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'imagen',
        'orden',
        'activa',
    ];

    protected $casts = [
        'activa'         => 'boolean',
        'fecha_creacion' => 'datetime',
    ];

    public function noticias(): BelongsToMany
    {
        return $this->belongsToMany(Noticia::class, 'categoria_noticia', 'categoria_id', 'noticia_id')
            ->withTimestamps('created_at', 'updated_at');
    }
}
