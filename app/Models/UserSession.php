<?php

namespace App\Models;

use App\Traits\HasUserAgent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSession extends Model
{
    use HasUserAgent;

    /**
     * Conexion a utilizar
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sessions';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id'; // La columna 'id' de la tabla sessions

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false; // El 'id' de la sesión no es auto-incrementable

    /**
     * The "type" of the primary key.
     *
     * @var string
     */
    protected $keyType = 'string'; // El 'id' de la sesión es una cadena

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'last_activity' => 'datetime',
    ];

    // RELACIONES
    /**
     * Usuario de la sesion
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
