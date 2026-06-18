<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Publico\ObtenerInicioDataAction;

class ObtenerInicioDataController extends Controller
{
    public function __invoke(Request $request, ObtenerInicioDataAction $action)
    {
        $data = $action->execute(
            $request->preview_carousel,
            $request->preview_section3_bg,
            $request->preview_section3_text
        );

        return view('welcome', $data);
    }
}
