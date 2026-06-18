<?php

namespace App\Interfaces;

interface OldFiles
{
    /**
     * Lista de archivos antiguos segun tiempo de la clase
     */
    public static function archivosAntiguos(): array;
}
