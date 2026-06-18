<?php

namespace App\Traits;

use App\Models\Observacion;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasObservacionesTrait
{
    /**
     * Observaciones
     * @return MorphMany
     */
    public function observaciones(): MorphMany
    {
        return $this->morphMany(Observacion::class, 'observaciontable');
    }

    /**
     * Ultima observacion
     */
    public function ulitmaObservacion()
    {
        return $this->morphOne(Observacion::class, 'observaciontable')->latestOfMany();
    }

    /**
     * Primera observacion
     */
    public function primeraObservacion()
    {
        return $this->morphOne(Observacion::class, 'observaciontable')->oldestOfMany();
    }
}
