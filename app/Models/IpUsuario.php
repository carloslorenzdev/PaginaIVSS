<?php

namespace App\Models;

use App\Traits\CreadorModificadorTrait;
use App\Traits\FormatoFechaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IpUsuario extends Model
{
    use CreadorModificadorTrait;
    use FormatoFechaTrait;

    /**
     * Conexion a utilizar
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * Nombre tabla
     * @var string
     */
    protected $table = 'ips_usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fk_usuario',
        'ip',
        'descripcion',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    // RELACIONES
    /**
     * Usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fk_usuario', 'id');
    }
}
