<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pais extends Model
{
    protected $table = 'npais';
    protected $primaryKey = 'idpais';
    public $timestamps = false;

    protected $fillable = [
        'idpais',
        'pais',
        'capital',
        'idcontinentefk',
        'idupdatefk',
        'updated_at',
    ];

    public function estados(): HasMany
    {
        return $this->hasMany(Estado::class, 'idpaisfk', 'idpais');
    }
}
