<?php

namespace App\Http\Controllers\Admin\Noticias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\Noticias\ObtenerNoticiasPanelAction;

class ListarNoticiasPanelController extends Controller
{
    public function __invoke(Request $request, ObtenerNoticiasPanelAction $action)
    {
        abort_if(!auth()->user()->can('admin.panel'), 403, 'No tienes permiso para ver el panel de administración.');
        $noticias = $action->execute($request->search);

        $publicadas    = \App\Models\Noticia::where('publicado', true)->count();
        $visitasHoy    = \App\Models\Visita::whereDate('fecha', today())->count();
        $visitasMes    = \App\Models\Visita::whereMonth('fecha', today()->month)->count();
        $visitasTotales = \App\Models\Visita::count();

        return view('admin.panel', compact('noticias', 'publicadas', 'visitasHoy', 'visitasMes', 'visitasTotales'));
    }
}
