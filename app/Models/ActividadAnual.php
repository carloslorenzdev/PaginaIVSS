<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ActividadAnual extends Model
{
    use HasFactory;

    protected $table = 'actividades_anuales';

    protected $fillable = [
        'titulo',
        'descripcion',
        'activa',
        'autor_id',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function medios(): BelongsToMany
    {
        return $this->belongsToMany(Medio::class, 'actividad_anual_medios', 'actividad_anual_id', 'medio_id')
            ->withPivot(['tipo_relacion', 'orden']);
    }
}
