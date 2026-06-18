<?php

namespace App\Models;

use App\Casts\TituloCast;
use App\Traits\CreadorModificadorTrait;
use App\Traits\FormatoFechaTrait;
use App\Traits\HasTwoFactorAuthTrait;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use CreadorModificadorTrait;
    use FormatoFechaTrait;
    use HasRoles;
    use SoftDeletes;
    use HasTwoFactorAuthTrait;

    /**
     * Conexión principal: PostgreSQL (pagina_ivss)
     */
    protected $connection = 'pgsql';

    protected $table = 'users';

    protected $fillable = [
        'usuario',
        'nombre',
        'email',
        'email_verified_at',
        'password',
        'cambio_pass',
        'bloqueado',
        'avatar',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_confirmed_at',
        'id_telegram',
        'telegram_confirmed_at',
    ];

    protected $with = [];

    protected function casts(): array
    {
        return [
            'nombre'                  => TituloCast::class,
            'email_verified_at'       => 'datetime',
            'password'                => 'hashed',
            'two_factor_secret'       => 'encrypted',
            'id_telegram'             => 'encrypted',
            'cambio_pass'             => 'datetime',
            'bloqueado'               => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'telegram_confirmed_at'   => 'datetime',
        ];
    }

    // ----------------------------------------------------------------
    // MUTADORES / ATRIBUTOS
    // ----------------------------------------------------------------

    public function iniciales(): Attribute
    {
        return Attribute::get(function () {
            $partes = explode(' ', $this->nombre);
            if (count($partes) < 2) {
                return strtoupper(substr($partes[0], 0, 2));
            }
            return strtoupper($partes[0][0] . $partes[1][0]);
        });
    }

    // ----------------------------------------------------------------
    // HELPERS DE ROL
    // ----------------------------------------------------------------

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isPrensaRedactor(): bool
    {
        return $this->hasRole('redactor');
    }

    public function isPrensaAprobador(): bool
    {
        return $this->hasRole('aprobador');
    }

    public function isActivo(): bool
    {
        return $this->bloqueado === null;
    }

    public function isBloqueado(): bool
    {
        return !$this->isActivo();
    }

    public function estatus(): string
    {
        return $this->isActivo() ? 'Activo' : 'Bloqueado';
    }

    public function colorEstatus(): string
    {
        return match ($this->estatus()) {
            'Activo'   => 'teal',
            'Bloqueado' => 'red',
            default    => 'blue',
        };
    }

    // ----------------------------------------------------------------
    // SCOPES
    // ----------------------------------------------------------------

    #[Scope]
    protected function activo(Builder $builder): void
    {
        $builder->whereNull('bloqueado');
    }

    // ----------------------------------------------------------------
    // RELACIONES
    // ----------------------------------------------------------------

    /**
     * Ingresos al sistema
     */
    public function accesos(): HasMany
    {
        return $this->hasMany(SesionUsuario::class, 'created_by', 'id');
    }

    /**
     * Último ingreso al sistema
     */
    public function ultimoAcceso(): HasOne
    {
        return $this->hasOne(SesionUsuario::class, 'created_by', 'id')->latestOfMany();
    }

    /**
     * Noticias creadas por este usuario
     */
    public function noticias(): HasMany
    {
        return $this->hasMany(Noticia::class, 'autor_id');
    }

    /**
     * Actividades anuales creadas por este usuario
     */
    public function actividades(): HasMany
    {
        return $this->hasMany(ActividadAnual::class, 'autor_id');
    }
}
