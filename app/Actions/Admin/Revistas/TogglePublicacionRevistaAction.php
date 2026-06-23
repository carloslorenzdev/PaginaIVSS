<?php

namespace App\Actions\Admin\Revistas;

use App\Models\Revista;

class TogglePublicacionRevistaAction
{
    public function execute(Revista $revista)
    {
        return $revista->update(['publicado' => !$revista->publicado]);
    }
}
