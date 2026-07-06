<?php

namespace App\Http\Controllers\Admin\Boletines;

use App\Http\Controllers\Controller;
use App\Models\Boletin;
use Illuminate\Http\Request;
use App\Actions\Admin\Boletines\GuardarBoletinAction;
use App\Actions\Admin\Boletines\ActualizarBoletinAction;
use App\Actions\Admin\Boletines\EliminarBoletinAction;
use App\Actions\Admin\Boletines\TogglePublicacionBoletinAction;

class BoletinAdminController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('boletines.ver')) {
            abort(403, 'No tienes permiso para ver boletines.');
        }

        $boletines = Boletin::orderBy('fecha_publicacion', 'desc')->paginate(10);
        return view('admin.boletines.index', compact('boletines'));
    }

    public function crear()
    {
        if (!auth()->user()->can('boletines.crear')) {
            abort(403, 'No tienes permiso para crear boletines.');
        }

        return view('admin.boletines.crear');
    }

    public function guardar(Request $request, GuardarBoletinAction $guardarBoletinAction)
    {
        if (!auth()->user()->can('boletines.crear')) {
            abort(403, 'No tienes permiso para guardar boletines.');
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'fecha_publicacion' => 'required|date',
            'archivo_pdf' => 'required|file|mimes:pdf|max:20480',
            'imagen_base64' => 'nullable|string',
        ]);

        $guardarBoletinAction->execute($validated);

        return redirect()->route('admin.boletines.index')->with('success', 'Boletín subido exitosamente.');
    }

    public function ver(Boletin $boletin)
    {
        if (!auth()->user()->can('boletines.ver')) {
            abort(403, 'No tienes permiso para ver boletines.');
        }

        return view('admin.boletines.ver', compact('boletin'));
    }

    public function actualizar(Request $request, Boletin $boletin, ActualizarBoletinAction $actualizarBoletinAction)
    {
        if (!auth()->user()->can('boletines.editar')) {
            abort(403, 'No tienes permiso para editar boletines.');
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'fecha_publicacion' => 'required|date',
            'archivo_pdf' => 'nullable|file|mimes:pdf|max:20480',
            'imagen_base64' => 'nullable|string',
        ]);

        $actualizarBoletinAction->execute($boletin, $validated);

        return redirect()->route('admin.boletines.index')->with('success', 'Boletín actualizado exitosamente.');
    }

    public function eliminar(Boletin $boletin, EliminarBoletinAction $eliminarBoletinAction)
    {
        if (!auth()->user()->can('boletines.eliminar')) {
            abort(403, 'No tienes permiso para eliminar boletines.');
        }

        $eliminarBoletinAction->execute($boletin);

        return redirect()->route('admin.boletines.index')->with('success', 'Boletín eliminado exitosamente.');
    }

    public function togglePublicacion(Boletin $boletin, TogglePublicacionBoletinAction $togglePublicacionBoletinAction)
    {
        if (!auth()->user()->can('boletines.editar')) {
            abort(403, 'No tienes permiso para cambiar el estado de publicación.');
        }

        $togglePublicacionBoletinAction->execute($boletin);

        return redirect()->back()->with('success', 'Estado del boletín actualizado.');
    }
}
