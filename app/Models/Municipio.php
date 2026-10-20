<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    protected $table = 'nmunicipio';
    protected $primaryKey = 'idmunicipio';
    public $timestamps = false;

    protected $fillable = [
        'idmunicipio',
        'idestadofk',
        'municipio',
        'idupdatefk',
        'updated_at',
    ];

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class, 'idestadofk', 'idestado');
    }

    public function parroquias(): HasMany
    {
        return $this->hasMany(Parroquia::class, 'idmunicipiofk', 'idmunicipio');
    }
}
