<?php

namespace App\Models;

use App\Casts\JsonCast;
use App\Traits\CreadorModificadorTrait;
use App\Traits\FormatoFechaTrait;
use App\Traits\HasUserAgent;
use Illuminate\Database\Eloquent\Model;

class SesionUsuario extends Model
{
    use CreadorModificadorTrait;
    use FormatoFechaTrait;
    use HasUserAgent;

    /**
     * Conexion a utilizar
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * Nombre tabla
     * @var string
     */
    protected $table = 'sesiones_usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'ip',
        'ips',
        'ip_client',
        'ips_client',
        'user_agent',
        'login',
        'logout',
        'id_sesion',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'ips' => JsonCast::class,
            'ips_client' => JsonCast::class,
            'login' => 'datetime',
            'logout' => 'datetime',
        ];
    }
}
