<?php

namespace App\Actions\Admin\Boletines;

use App\Models\Boletin;

class TogglePublicacionBoletinAction
{
    public function execute(Boletin $boletin)
    {
        return $boletin->update(['publicado' => !$boletin->publicado]);
    }
}
