<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parroquia extends Model
{
    protected $table = 'nparroquia';
    protected $primaryKey = 'idparroquia';
    public $timestamps = false;

    protected $fillable = [
        'idparroquia',
        'idmunicipiofk',
        'parroquia',
        'idupdatefk',
        'updated_at',
    ];

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'idmunicipiofk', 'idmunicipio');
    }
}
