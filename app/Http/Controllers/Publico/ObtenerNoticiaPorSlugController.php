<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Actions\Publico\ObtenerNoticiaPorSlugAction;

class ObtenerNoticiaPorSlugController extends Controller
{
    public function __invoke($slug, ObtenerNoticiaPorSlugAction $action)
    {
        $noticia = $action->execute($slug);
        return view('noticia', compact('noticia'));
    }
}
