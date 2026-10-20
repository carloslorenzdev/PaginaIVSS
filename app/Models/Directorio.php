<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directorio extends Model
{
    use HasFactory;

    protected $table = 'directorios';

    protected $fillable = [
        'tipo',
        'estado',
        'municipio',
        'parroquia',
        'id_estado',
        'id_municipio',
        'id_parroquia',
        'nombre',
        'direccion',
        'telefono',
    ];

    public function estadoRelacion()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'idestado');
    }

    public function municipioRelacion()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio', 'idmunicipio');
    }

    public function parroquiaRelacion()
    {
        return $this->belongsTo(Parroquia::class, 'id_parroquia', 'idparroquia');
    }

    public function scopeFarmacias($query)
    {
        return $query->where('tipo', 'farmacia');
    }

    public function scopeCentrosSalud($query)
    {
        return $query->where('tipo', 'centro_salud');
    }

    public function scopeOficinasAdministrativas($query)
    {
        return $query->where('tipo', 'oficina_administrativa');
    }
}
