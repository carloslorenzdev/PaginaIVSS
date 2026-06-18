<?php

namespace App\Http\Controllers\Admin\Categorias;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuardarCategoriaController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!auth()->user()->hasAnyRole(['admin'])) {
            abort(403, 'No tienes permiso para guardar categorias.');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'orden' => 'nullable|integer',
            'activa' => 'nullable|boolean'
        ]);

        Categoria::create([
            'nombre' => $request->nombre,
            'slug' => Str::slug($request->nombre),
            'descripcion' => $request->descripcion,
            'orden' => $request->orden ?? 0,
            'activa' => $request->has('activa') ? 1 : 0
        ]);

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada exitosamente.');
    }
}
