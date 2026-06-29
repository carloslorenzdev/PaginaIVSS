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
        'nombre',
        'direccion',
        'telefono',
    ];

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
