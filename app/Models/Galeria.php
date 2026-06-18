<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Galeria extends Model
{
    use HasFactory;

    protected $table = 'galerias';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'categoria_id',
        'portada_id',
        'usuario_id',
        'activa',
    ];

    protected $casts = [
        'activa'         => 'boolean',
        'fecha_creacion' => 'datetime',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function portada(): BelongsTo
    {
        return $this->belongsTo(Medio::class, 'portada_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function medios(): BelongsToMany
    {
        return $this->belongsToMany(Medio::class, 'galerias_medios', 'galeria_id', 'medio_id')
            ->withPivot(['orden'])
            ->withTimestamps();
    }
}
