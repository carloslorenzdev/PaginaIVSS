<?php

namespace App\Http\Controllers\Admin\ActividadesAnuales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\ActividadesAnuales\ObtenerActividadesAnualesAction;
use Illuminate\Support\Facades\Artisan;

class ListarActividadesAnualesController extends Controller
{
    public function __invoke(Request $request, ObtenerActividadesAnualesAction $action)
    {
        try {
            $actividades = $action->execute($request->search);
            return view('admin.actividades.index', compact('actividades'));
            
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'actividades_anuales')) {
                try {
                    Artisan::call('migrate', ['--force' => true]);
                    return redirect()->route('admin.actividades')->with('success', 'Base de datos actualizada automáticamente. Ya puedes usar el módulo.');
                } catch (\Exception $e2) {
                    return redirect()->route('admin.panel')->withErrors(['Error al auto-migrar: ' . $e2->getMessage()]);
                }
            }
            throw $e;
        }
    }
}
