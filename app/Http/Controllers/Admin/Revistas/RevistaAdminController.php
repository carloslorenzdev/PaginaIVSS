<?php

namespace App\Http\Controllers\Admin\Revistas;

use App\Http\Controllers\Controller;
use App\Models\Revista;
use Illuminate\Http\Request;
use App\Actions\Admin\Revistas\GuardarRevistaAction;
use App\Actions\Admin\Revistas\ActualizarRevistaAction;
use App\Actions\Admin\Revistas\EliminarRevistaAction;
use App\Actions\Admin\Revistas\TogglePublicacionRevistaAction;

class RevistaAdminController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('revistas.ver')) {
            abort(403, 'No tienes permiso para ver revistas.');
        }

        $revistas = Revista::orderBy('fecha_publicacion', 'desc')->paginate(10);
        return view('admin.revistas.index', compact('revistas'));
    }

    public function crear()
    {
        if (!auth()->user()->can('revistas.crear')) {
            abort(403, 'No tienes permiso para crear revistas.');
        }

        return view('admin.revistas.crear');
    }

    public function guardar(Request $request, GuardarRevistaAction $guardarRevistaAction)
    {
        if (!auth()->user()->can('revistas.crear')) {
            abort(403, 'No tienes permiso para guardar revistas.');
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'edicion' => 'nullable|string|max:255',
            'fecha_publicacion' => 'required|date',
            'archivo_pdf' => 'required|file|mimes:pdf|max:20480',
            'imagen_base64' => 'nullable|string',
        ]);

        $guardarRevistaAction->execute($validated);

        return redirect()->route('admin.revistas.index')->with('success', 'Revista subida exitosamente.');
    }

    public function ver(Revista $revista)
    {
        if (!auth()->user()->can('revistas.ver')) {
            abort(403, 'No tienes permiso para ver revistas.');
        }

        return view('admin.revistas.ver', compact('revista'));
    }

    public function actualizar(Request $request, Revista $revista, ActualizarRevistaAction $actualizarRevistaAction)
    {
        if (!auth()->user()->can('revistas.editar')) {
            abort(403, 'No tienes permiso para editar revistas.');
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'edicion' => 'nullable|string|max:255',
            'fecha_publicacion' => 'required|date',
            'archivo_pdf' => 'nullable|file|mimes:pdf|max:20480',
            'imagen_base64' => 'nullable|string',
        ]);

        $actualizarRevistaAction->execute($revista, $validated);

        return redirect()->route('admin.revistas.index')->with('success', 'Revista actualizada exitosamente.');
    }

    public function eliminar(Revista $revista, EliminarRevistaAction $eliminarRevistaAction)
    {
        if (!auth()->user()->can('revistas.eliminar')) {
            abort(403, 'No tienes permiso para eliminar revistas.');
        }

        $eliminarRevistaAction->execute($revista);

        return redirect()->route('admin.revistas.index')->with('success', 'Revista eliminada exitosamente.');
    }

    public function togglePublicacion(Revista $revista, TogglePublicacionRevistaAction $togglePublicacionRevistaAction)
    {
        if (!auth()->user()->can('revistas.editar')) {
            abort(403, 'No tienes permiso para cambiar el estado de publicación.');
        }

        $togglePublicacionRevistaAction->execute($revista);

        return redirect()->back()->with('success', 'Estado de la revista actualizado.');
    }
}
