<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estado extends Model
{
    protected $table = 'nestado';
    protected $primaryKey = 'idestado';
    public $timestamps = false;

    protected $fillable = [
        'idestado',
        'idpaisfk',
        'estado',
        'nomenclatura',
        'capital',
        'idupdatefk',
        'updated_at',
    ];

    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'idpaisfk', 'idpais');
    }

    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class, 'idestadofk', 'idestado');
    }
}
