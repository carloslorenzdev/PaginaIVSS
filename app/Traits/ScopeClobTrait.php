<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ScopeClobTrait
{
    /**
     * wHERE par buscar en columnas CLOB
     * @param Builder $builder
     * @param string $columna
     * @param string $texto
     * @return Builder
     */
    public function scopeClob(Builder $builder, string $columna, string $texto): Builder
    {
        return $builder->whereRaw("DBMS_LOB.SUBSTR(" . $columna . ", 4000, 1) LIKE ?", ["%" . $texto . "%"]);
    }
}
