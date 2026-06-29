<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Directorio;
use Illuminate\Http\Request;

class DirectorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Directorio::query();

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $directorios = $query->orderBy('estado')->orderBy('nombre')->paginate(15)->withQueryString();

        return view('admin.directorios.index', compact('directorios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:farmacia,centro_salud,oficina_administrativa',
            'estado' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string',
            'telefono' => 'nullable|string|max:255',
        ]);

        Directorio::create($request->all());

        return redirect()->route('admin.directorios.index', ['tipo' => $request->tipo])
            ->with('success', 'Locación registrada exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Directorio $directorio)
    {
        $request->validate([
            'tipo' => 'required|in:farmacia,centro_salud,oficina_administrativa',
            'estado' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string',
            'telefono' => 'nullable|string|max:255',
        ]);

        $directorio->update($request->all());

        return redirect()->route('admin.directorios.index', ['tipo' => $request->tipo])
            ->with('success', 'Locación actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Directorio $directorio)
    {
        $tipo = $directorio->tipo;
        $directorio->delete();

        return redirect()->route('admin.directorios.index', ['tipo' => $tipo])
            ->with('success', 'Locación eliminada exitosamente.');
    }
}
